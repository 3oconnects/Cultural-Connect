<?php
include '../includes/db.php';
include '../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Get user_id first to delete from users table too
    $res = $conn->query("SELECT user_id FROM residents WHERE id = $id");
    if ($row = $res->fetch_assoc()) {
        $user_id = $row['user_id'];
        $conn->query("DELETE FROM residents WHERE id = $id");
        $conn->query("DELETE FROM users WHERE id = $user_id");
    }
}

header("Location: list_residents.php?msg=deleted");
exit();