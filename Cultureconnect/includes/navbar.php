<div class="topbar glass-morphism">
    <div class="brand">
        <i class="fas fa-circle-nodes text-primary me-2"></i>
        <span>CultureConnect</span>
    </div>

    <div class="right-info">
        <div class="user-profile me-3 d-none d-md-flex align-items-center">
            <div class="avatar bg-primary-soft text-primary rounded-circle me-2 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                <i class="fas fa-user-tie"></i>
            </div>
            <span class="fw-semibold text-dark"><?php echo $_SESSION['full_name']; ?></span>
        </div>
        <a href="logout.php" class="logout-btn px-3 py-2">
            <i class="fas fa-power-off me-2"></i> Logout
        </a>
    </div>
</div>