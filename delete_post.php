<?php
session_start();
include 'includes/connection.php';
$id = intval($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: posts.php'); exit; }

$r = mysqli_query($conn, "SELECT alumni_id FROM posts WHERE id = $id LIMIT 1");
if (!$r || mysqli_num_rows($r) == 0) { header('Location: posts.php'); exit; }
$row = mysqli_fetch_assoc($r);
$post_owner = intval($row['alumni_id']);

$allowed = false;
if (isset($_SESSION['admin_id'])) $allowed = true;
if (isset($_SESSION['alumni_id']) && intval($_SESSION['alumni_id']) === $post_owner) $allowed = true;

if ($allowed) {
    mysqli_query($conn, "DELETE FROM posts WHERE id = $id");
}
// comments removed automatically if FK ON DELETE CASCADE exists
$back = $_SERVER['HTTP_REFERER'] ?? 'posts.php';
header("Location: $back");
exit;