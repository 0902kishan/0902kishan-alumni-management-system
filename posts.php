<?php
session_start();
include 'includes/connection.php';
$sql = "SELECT p.id, p.title, p.body, p.created_at, p.alumni_id as post_owner_id, a.name
        FROM posts p
        LEFT JOIN alumni a ON p.alumni_id = a.id
        WHERE p.approved = 1
        ORDER BY p.created_at DESC";
$res = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
    .menu-btn {
        border: 0;
        background: transparent;
        font-size: 20px;
        line-height: 1;
        padding: 4px 8px;
    }

    .menu {
        position: relative;
        display: inline-block;
    }

    .menu-items {
        display: none;
        position: absolute;
        right: 0;
        top: 26px;
        background: #fff;
        border: 1px solid rgba(0, 0, 0, 0.08);
        min-width: 140px;
        z-index: 50;
        border-radius: 6px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
    }

    .dark-mode .menu-items,
    .dark-theme .menu-items {
        background: #0b1220;
        color: #e6eef6;
        border-color: rgba(255, 255, 255, 0.06);
    }

    .menu-items a {
        display: block;
        padding: 8px 12px;
        text-decoration: none;
        color: inherit;
    }

    .menu-items a:hover {
        background: rgba(0, 0, 0, 0.04);
    }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3">
            <h3>Alumni Posts</h3>
            <div>
                <a href="index.php" class="btn btn-sm btn-outline-secondary">Home</a>
                <?php if(isset($_SESSION['alumni_id'])): ?><a href="create_post.php"
                    class="btn btn-sm btn-outline-primary">Create Post</a><?php else: ?><a href="login.php"
                    class="btn btn-sm btn-outline-primary">Login to Post</a><?php endif; ?>
                <button id="themeToggle" class="btn btn-sm btn-outline-primary">Dark</button>
            </div>
        </div>

        <?php if(!$res || mysqli_num_rows($res)==0): ?>
        <div class="alert alert-info">No posts available.</div>
        <?php else: while($p=mysqli_fetch_assoc($res)): $post_id=intval($p['id']); $post_owner_id=intval($p['post_owner_id']); ?>
        <div class="card mb-3" data-post-id="<?= $post_id ?>">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5><?= htmlspecialchars($p['title']) ?></h5>
                        <small class="text-muted">By <?= htmlspecialchars($p['name'] ?? 'Unknown') ?> —
                            <?= htmlspecialchars($p['created_at']) ?></small>
                    </div>
                    <div class="menu">
                        <button class="menu-btn" data-post-id="<?= $post_id ?>" aria-label="menu">⋯</button>
                        <div class="menu-items" data-for-post="<?= $post_id ?>">
                            <a href="#" class="report-item" data-type="post" data-target="<?= $post_id ?>">Report
                                Post</a>
                            <?php if((isset($_SESSION['admin_id'])) || (isset($_SESSION['alumni_id']) && intval($_SESSION['alumni_id'])=== $post_owner_id)): ?>
                            <a href="delete_post.php?id=<?= $post_id ?>" class="delete-post">Delete Post</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <p class="mt-2"><?= nl2br(htmlspecialchars($p['body'])) ?></p>

                <?php
        $csql = "SELECT c.id, c.content, c.created_at, c.alumni_id as comment_owner_id, a.name
                 FROM comments c LEFT JOIN alumni a ON c.alumni_id = a.id
                 WHERE c.post_id = $post_id
                 ORDER BY c.created_at ASC";
        $cres = mysqli_query($conn, $csql);
        $initial_count = $cres ? mysqli_num_rows($cres) : 0;
        ?>

                <hr>
                <h6 class="mb-2">Comments (<span class="comments-count"><?= $initial_count ?></span>)</h6>

                <div class="comments-list" data-post-id="<?= $post_id ?>">
                    <?php if($cres && mysqli_num_rows($cres)>0): while($com=mysqli_fetch_assoc($cres)): ?>
                    <div class="mb-2 comment-item" data-comment-id="<?= intval($com['id']) ?>">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong><?= htmlspecialchars($com['name'] ?? 'Alumni') ?></strong>
                                <small class="text-muted"> — <?= htmlspecialchars($com['created_at']) ?></small>
                                <p class="mb-1"><?= nl2br(htmlspecialchars($com['content'])) ?></p>
                            </div>
                            <div class="menu">
                                <button class="menu-btn" data-comment-id="<?= intval($com['id']) ?>">⋯</button>
                                <div class="menu-items" data-for-comment="<?= intval($com['id']) ?>">
                                    <a href="#" class="report-item" data-type="comment"
                                        data-target="<?= intval($com['id']) ?>">Report Comment</a>
                                    <?php
                      $can_delete = false;
                      if(isset($_SESSION['admin_id'])) $can_delete = true;
                      if(isset($_SESSION['alumni_id']) && intval($_SESSION['alumni_id'])=== intval($com['comment_owner_id'])) $can_delete = true;
                      if(isset($_SESSION['alumni_id']) && intval($_SESSION['alumni_id'])=== $post_owner_id) $can_delete = true;
                      if($can_delete):
                    ?>
                                    <a href="delete_comment.php?id=<?= intval($com['id']) ?>"
                                        class="delete-comment">Delete Comment</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; else: ?>
                    <div class="text-muted mb-2">No comments yet.</div>
                    <?php endif; ?>
                </div>

                <?php if(isset($_SESSION['alumni_id'])): ?>
                <form method="POST" action="add_comment.php" class="mt-3 ajax-comment">
                    <input type="hidden" name="post_id" value="<?= $post_id ?>">
                    <textarea name="content" class="form-control mb-2" rows="2" placeholder="Write a comment..."
                        required></textarea>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-primary">Post Comment</button>
                    </div>
                </form>
                <?php else: ?>
                <div class="small text-muted mt-2">Please <a href="login.php">login</a> to comment.</div>
                <?php endif; ?>

            </div>
        </div>
        <?php endwhile; endif; ?>

    </div>

    <script src="js/app.js"></script>
    <script src="js/comments.js"></script>
    <script>
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.menu-btn');
        if (btn) {
            var container = btn.parentElement;
            var items = container.querySelector('.menu-items');
            document.querySelectorAll('.menu-items').forEach(function(mi) {
                if (mi !== items) mi.style.display = 'none';
            });
            items.style.display = (items.style.display === 'block') ? 'none' : 'block';
            return;
        }
        if (!e.target.closest('.menu')) document.querySelectorAll('.menu-items').forEach(function(mi) {
            mi.style.display = 'none';
        });
    });
    </script>
</body>

</html>