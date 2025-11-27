(function() {
    const key = 'alumni_theme';
    const root = document.documentElement;

    function apply(t) {
        if (t === 'dark') root.classList.add('dark-theme');
        else root.classList.remove('dark-theme');
    }

    const stored = localStorage.getItem(key);
    if (stored) apply(stored);
    else {
        const sys = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        apply(sys ? 'dark' : 'light');
    }

    const btn = document.getElementById('themeToggle');
    if (btn) {
        btn.addEventListener('click', () => {
            const d = root.classList.toggle('dark-theme');
            localStorage.setItem(key, d ? 'dark' : 'light');
            btn.innerText = d ? 'Light' : 'Dark';
        });
        btn.innerText = root.classList.contains('dark-theme') ? 'Light' : 'Dark';
    }

    document.addEventListener('click', function(e) {
        const el = e.target.closest('.btn');
        if (!el) return;
        const r = el.getBoundingClientRect();
        const s = Math.max(r.width, r.height) * 1.2;
        const x = e.clientX - r.left - s / 2;
        const y = e.clientY - r.top - s / 2;
        const rp = document.createElement('span');
        rp.className = 'ripple';
        rp.style.width = s + 'px';
        rp.style.height = s + 'px';
        rp.style.left = x + 'px';
        rp.style.top = y + 'px';
        el.appendChild(rp);
        setTimeout(() => rp.remove(), 700);
    }, { passive: true });
})();