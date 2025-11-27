<?php
session_start();
include '../includes/connection.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

$id  = intval($_GET['id'] ?? 0);
$act = $_GET['act'] ?? '';

if ($id > 0) {
    if ($act === 'approve') {
        mysqli_query($conn, "UPDATE posts SET approved = 1 WHERE id = $id");
    } elseif ($act === 'delete') {
        mysqli_query($conn, "DELETE FROM posts WHERE id = $id");
    }
}

header("Location: pending_posts.php");
exit;