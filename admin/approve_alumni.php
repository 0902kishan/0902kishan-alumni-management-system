<?php
session_start();
include '../includes/connection.php';

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header("Location: admin_login.php");
    exit;
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

if (isset($_GET['id'], $_GET['act'])) {
    $id = intval($_GET['id']);
    $act = $_GET['act'];

    if ($act === 'approve') {
        mysqli_query($conn, "UPDATE alumni SET approved=1 WHERE id=$id");
    } elseif ($act === 'delete') {
        mysqli_query($conn, "DELETE FROM alumni WHERE id=$id");
    }
}

header("Location: dashboard.php");
exit;