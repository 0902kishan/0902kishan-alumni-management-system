(function() {
    function toast(msg, ok) {
        var el = document.createElement('div');
        el.style.position = 'fixed';
        el.style.right = '18px';
        el.style.top = '18px';
        el.style.zIndex = 9999;
        el.style.padding = '10px 14px';
        el.style.borderRadius = '8px';
        el.style.boxShadow = '0 6px 18px rgba(0,0,0,0.15)';
        el.style.background = ok ? '#10b981' : '#ef4444';
        el.style.color = '#fff';
        el.style.fontWeight = 600;
        el.innerText = msg;
        document.body.appendChild(el);
        setTimeout(function() { el.remove(); }, 2200);
    }

    function sendJSON(url, data) {
        return fetch(url, {
            method: 'POST',
            body: data,
            credentials: 'same-origin',
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        }).then(async function(r) {
            var ct = r.headers.get('content-type') || '';
            if (ct.indexOf('application/json') !== -1) return r.json();
            var t = await r.text();
            try { return JSON.parse(t); } catch (e) { return { ok: false, text: t.slice(0, 400) }; }
        });
    }

    function escapeHtml(s) { return String(s || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;'); }

    function renderCommentHtml(c) {
        var name = c.name || 'Alumni';
        var created = c.created_at || '';
        var content = (c.content || '').replace(/\n/g, '<br>');
        return '<div class="mb-2"><strong>' + escapeHtml(name) + '</strong> <small class="text-muted"> — ' + escapeHtml(created) + '</small><p class="mb-1">' + content + '</p></div>';
    }

    document.addEventListener('submit', function(e) {
        var form = e.target;
        if (!form.classList || !form.classList.contains('ajax-comment')) return;
        e.preventDefault();
        var textarea = form.querySelector('textarea[name="content"]');
        var submitBtn = form.querySelector('button');
        var post_input = form.querySelector('input[name="post_id"]');
        if (!textarea || !submitBtn || !post_input) return;
        var post_id = post_input.value;
        var textVal = textarea.value.trim();
        if (textVal === '') return;
        submitBtn.disabled = true;
        var fd = new FormData(form);
        sendJSON('add_comment.php', fd).then(function(resp) {
            submitBtn.disabled = false;
            if (!resp) { toast('Server error', false); return; }
            if (resp.ok) {
                var container = form.closest('.card').querySelector('.comments-list[data-post-id="' + post_id + '"]');
                if (container) container.insertAdjacentHTML('beforeend', renderCommentHtml(resp.comment));
                var cnt = form.closest('.card').querySelector('.comments-count');
                if (cnt) cnt.innerText = (parseInt(cnt.innerText || '0') + 1);
                textarea.value = '';
                toast('Comment added', true);
            } else {
                var err = resp.error || resp.message || 'Server error';
                if (err === 'not_logged_in') {
                    toast('Login required', false);
                    setTimeout(function() { location.href = 'login.php'; }, 900);
                    return;
                }
                toast(err, false);
            }
        }).catch(function(err) {
            submitBtn.disabled = false;
            toast('Network error', false);
            console.error('add_comment error:', err);
        });
    }, { passive: false });

    function fetchAndRender(postId, container) {
        fetch('fetch_comments.php?post_id=' + postId, { credentials: 'same-origin' }).then(function(r) { return r.json(); }).then(function(list) {
            container.innerHTML = '';
            list.forEach(function(c) { container.insertAdjacentHTML('beforeend', renderCommentHtml(c)); });
            var card = container.closest('.card');
            var cnt = card.querySelector('.comments-count');
            if (cnt) cnt.innerText = list.length;
        }).catch(function() {});
    }

    setTimeout(function() {
        var lists = document.querySelectorAll('.comments-list[data-post-id]');
        lists.forEach(function(cont) {
            var pid = cont.getAttribute('data-post-id');
            if (!pid) return;
            fetchAndRender(pid, cont);
            setInterval(function() { fetchAndRender(pid, cont); }, 5000);
        });
    }, 300);

    function showCenteredPopup(text) {
        var box = document.createElement('div');
        box.style.position = 'fixed';
        box.style.left = '50%';
        box.style.top = '30%';
        box.style.transform = 'translateX(-50%)';
        box.style.padding = '14px 18px';
        box.style.background = 'rgba(0,0,0,0.85)';
        box.style.color = '#fff';
        box.style.borderRadius = '10px';
        box.style.zIndex = 10001;
        box.style.fontWeight = 600;
        box.style.boxShadow = '0 8px 24px rgba(0,0,0,0.35)';
        box.innerText = text;
        document.body.appendChild(box);
        setTimeout(function() {
            box.style.transition = 'opacity .4s';
            box.style.opacity = '0';
            setTimeout(function() { box.remove(); }, 420);
        }, 1600);
    }

    document.addEventListener('click', function(e) {
        var rep = e.target.closest('.report-item');
        if (rep) {
            e.preventDefault();
            var type = rep.getAttribute('data-type');
            var target = rep.getAttribute('data-target');
            var fd = new FormData();
            fd.append('type', type);
            fd.append('target_id', target);
            sendJSON('report.php', fd).then(function(resp) {
                if (resp && resp.ok) {
                    toast('Reported to admin', true);
                    showCenteredPopup('Reported');
                } else {
                    toast('Report failed', false);
                }
            }).catch(function() { toast('Network error', false); });
            document.querySelectorAll('.menu-items').forEach(function(m) { m.style.display = 'none'; });
        }
    });
})();