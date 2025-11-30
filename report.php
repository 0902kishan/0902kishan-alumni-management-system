<?php
session_start();
include 'includes/connection.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(400); echo json_encode(['ok'=>false]); exit; }
if (!isset($_SESSION['alumni_id'])) { http_response_code(401); echo json_encode(['ok'=>false,'error'=>'login']); exit; }
$type = $_POST['type'] ?? '';
$target = intval($_POST['target_id'] ?? 0);
$reporter = intval($_SESSION['alumni_id']);
if (!in_array($type,['post','comment']) || $target<=0) { http_response_code(400); echo json_encode(['ok'=>false]); exit; }
$q = "INSERT INTO notifications (type,target_id,reporter_id) VALUES ('$type',$target,$reporter)";
if (!mysqli_query($conn,$q)) { http_response_code(500); echo json_encode(['ok'=>false]); exit; }
echo json_encode(['ok'=>true]);