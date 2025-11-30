<?php
session_start();
include 'includes/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header("Location: posts.php"); exit; }

if (!isset($_SESSION['alumni_id'])) {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        http_response_code(401);
        echo json_encode(['ok'=>false,'error'=>'not_logged_in']);
        exit;
    }
    header("Location: login.php");
    exit;
}

$post_id = intval($_POST['post_id'] ?? 0);
$content = trim($_POST['content'] ?? '');

if ($post_id <= 0 || $content === '') {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        http_response_code(400);
        echo json_encode(['ok'=>false,'error'=>'missing']);
        exit;
    }
    header("Location: posts.php");
    exit;
}

$alumni_id = intval($_SESSION['alumni_id']);
$content_safe = mysqli_real_escape_string($conn, $content);

$q = "INSERT INTO comments (post_id, alumni_id, content) VALUES ($post_id, $alumni_id, '$content_safe')";
$ok = mysqli_query($conn, $q);
if (!$ok) {
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        http_response_code(500);
        echo json_encode(['ok'=>false,'error'=>mysqli_error($conn)]);
        exit;
    }
    header("Location: posts.php");
    exit;
}

$comment_id = mysqli_insert_id($conn);
$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT c.id, c.content, c.created_at, a.name FROM comments c LEFT JOIN alumni a ON c.alumni_id=a.id WHERE c.id=$comment_id LIMIT 1"));

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    header('Content-Type: application/json');
    echo json_encode(['ok'=>true,'comment'=>$row]);
    exit;
}

$back = $_SERVER['HTTP_REFERER'] ?? 'posts.php';
header("Location: $back");
exit;