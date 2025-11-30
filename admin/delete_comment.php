<?php
session_start();
include '../includes/connection.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}
$id = intval($_GET['id'] ?? 0);
if ($id > 0) {
    mysqli_query($conn, "DELETE FROM comments WHERE id = $id");
}
$back = $_SERVER['HTTP_REFERER'] ?? 'dashboard.php';
header("Location: $back");
exit;