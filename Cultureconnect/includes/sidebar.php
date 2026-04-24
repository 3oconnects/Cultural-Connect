<?php
$current_url = $_SERVER['PHP_SELF'];
$in_admin = strpos($current_url, '/admin/') !== false;
$in_auth = strpos($current_url, '/auth/') !== false;

$root_prefix = ($in_admin || $in_auth) ? '../' : '';
$admin_prefix = $in_admin ? '' : 'admin/';
$auth_prefix = $in_auth ? '' : 'auth/';
?>
<div id="sidebar">
    <div class="sidebar-header">
        <div class="d-flex align-items-center">
            <div class="logo-icon bg-primary text-white p-2 rounded-3 me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px;">
                <i class="fas fa-circle-nodes"></i>
            </div>
            <span class="fw-800 text-white h6 mb-0">CultureConnect</span>
        </div>
        <button class="toggle-btn" onclick="toggleSidebar()">
            <i class="fas fa-angle-left" id="toggle-icon"></i>
        </button>
    </div>

    <div class="nav-section-title">Main Navigation</div>
    
    <a href="<?php echo $root_prefix; ?>dashboard.php" class="nav-item <?php echo basename($current_url) == 'dashboard.php' ? 'active' : ''; ?>">
        <i class="fas fa-chart-line"></i>
        <span>Dashboard</span>
    </a>

    <?php if($_SESSION['role'] == 'admin'): ?>
    <a href="<?php echo $root_prefix; ?><?php echo $admin_prefix; ?>list_areas.php" class="nav-item <?php echo basename($current_url) == 'list_areas.php' ? 'active' : ''; ?>">
        <i class="fas fa-map-location-dot"></i>
        <span>Manage Areas</span>
    </a>
    <a href="<?php echo $root_prefix; ?><?php echo $admin_prefix; ?>list_residents.php" class="nav-item <?php echo basename($current_url) == 'list_residents.php' ? 'active' : ''; ?>">
        <i class="fas fa-users"></i>
        <span>Residents</span>
    </a>
    <a href="<?php echo $root_prefix; ?><?php echo $admin_prefix; ?>list_companies.php" class="nav-item <?php echo basename($current_url) == 'list_companies.php' ? 'active' : ''; ?>">
        <i class="fas fa-building-columns"></i>
        <span>Entities</span>
    </a>
    <a href="<?php echo $root_prefix; ?><?php echo $admin_prefix; ?>list_offerings.php" class="nav-item <?php echo basename($current_url) == 'list_offerings.php' ? 'active' : ''; ?>">
        <i class="fas fa-boxes-stacked"></i>
        <span>Offerings</span>
    </a>
    <?php endif; ?>

    <div class="nav-section-title">Explore</div>
    <a href="<?php echo $root_prefix; ?>discovery.php" class="nav-item <?php echo basename($current_url) == 'discovery.php' ? 'active' : ''; ?>">
        <i class="fas fa-compass"></i>
        <span>Discovery</span>
    </a>
    <a href="<?php echo $root_prefix; ?>analytics.php" class="nav-item <?php echo basename($current_url) == 'analytics.php' ? 'active' : ''; ?>">
        <i class="fas fa-magnifying-glass-chart"></i>
        <span>Analytics</span>
    </a>

    <div style="margin-top: auto; padding-bottom: 20px;">
        <a href="<?php echo $root_prefix; ?><?php echo $auth_prefix; ?>logout.php" class="nav-item text-danger">
            <i class="fas fa-right-from-bracket"></i>
            <span>Sign Out</span>
        </a>
    </div>
</div>

<script>
function toggleSidebar() {
    const body = document.body;
    const sidebar = document.getElementById('sidebar');
    const icon = document.getElementById('toggle-icon');
    
    sidebar.classList.toggle('collapsed');
    body.classList.toggle('sidebar-collapsed');
    
    if(sidebar.classList.contains('collapsed')) {
        icon.classList.replace('fa-angle-left', 'fa-angle-right');
    } else {
        icon.classList.replace('fa-angle-right', 'fa-angle-left');
    }
}
</script>