<?php
session_start();
include '../includes/connection.php';
if(!isset($_SESSION['admin_id'])){ header("Location: admin_login.php"); exit; }
$id = intval($_GET['id'] ?? 0);
if($id>0) mysqli_query($conn,"UPDATE notifications SET seen=1 WHERE id=$id");
header("Location: notifications.php");
exit;