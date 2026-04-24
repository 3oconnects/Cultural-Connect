<?php
include_once 'db.php';
include_once 'config.php';

$current_url = $_SERVER['PHP_SELF'];
$in_admin = strpos($current_url, '/admin/') !== false;
$in_auth = strpos($current_url, '/auth/') !== false;

if (!isset($_SESSION['user_id'])) {
    $login_path = ($in_admin || $in_auth) ? '../auth/login.php' : 'auth/login.php';
    header("Location: $login_path");
    exit();
}

$page_title = isset($page_title) ? $page_title : "CultureConnect Portal";
$base_path = ($in_admin || $in_auth) ? '../' : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | CultureConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="<?php echo $base_path; ?>assets/css/style.css?v=1.4" rel="stylesheet">
</head>
<body>

<div class="dashboard-wrapper">
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <header class="global-header glass border-bottom px-4">
            <div class="d-flex justify-content-between align-items-center w-100">
                <div class="search-container flex-grow-1">
                    <div class="search-bar glass px-4 py-2 rounded-pill d-flex align-items-center bg-white shadow-sm border mx-auto" style="max-width: 550px;">
                        <i class="fas fa-search text-muted me-3"></i>
                        <input type="text" class="border-0 w-100 bg-transparent" placeholder="Search the community..." style="outline: none; font-size: 14px;">
                        <kbd class="bg-light text-muted border px-2 py-1 rounded small ms-2 d-none d-md-block">/</kbd>
                    </div>
                </div>
                <div class="header-actions d-flex align-items-center gap-3 ms-auto">
                    <div class="d-none d-lg-block">
                        <div class="text-end line-height-1">
                            <div class="fw-bold small text-dark"><?php echo $_SESSION['full_name']; ?></div>
                            <div class="text-muted smaller text-uppercase fw-800" style="font-size: 10px; letter-spacing: 0.5px;"><?php echo $_SESSION['role']; ?></div>
                        </div>
                    </div>
                    <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px; border: 2px solid #fff;">
                        <i class="fas fa-user-shield small"></i>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-fluid px-4 animate-fade-in">
