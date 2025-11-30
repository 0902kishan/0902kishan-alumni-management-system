<?php
include 'includes/connection.php';
$post_id = intval($_GET['post_id'] ?? 0);
if ($post_id <= 0) { echo json_encode([]); exit; }
$sql = "SELECT c.id, c.content, c.created_at, c.alumni_id, a.name
        FROM comments c LEFT JOIN alumni a ON c.alumni_id=a.id
        WHERE c.post_id = $post_id
        ORDER BY c.created_at ASC";
$res = mysqli_query($conn, $sql);
$out = [];
while ($r = mysqli_fetch_assoc($res)) $out[] = $r;
header('Content-Type: application/json');
echo json_encode($out);