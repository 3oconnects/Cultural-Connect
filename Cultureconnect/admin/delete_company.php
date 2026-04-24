<?php
include '../includes/db.php';
include '../includes/config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    // Optional: Check for foreign key constraints if needed
    $conn->query("DELETE FROM companies WHERE id = $id");
}

header("Location: list_companies.php?msg=deleted");
exit();