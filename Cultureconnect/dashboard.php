<?php 
$page_title = "Overview Dashboard";
include 'includes/header.php'; 
?>

<div class="mb-5 animate-fade-in">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-800 mb-1">System Overview</h2>
            <p class="text-muted mb-0">Real-time metrics and cultural growth indicators.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-purple shadow-sm px-4 py-2 rounded-3 fw-bold"><i class="fas fa-plus me-2"></i> New Action</button>
        </div>
    </div>
</div>

<!-- MODERN KPI GRID -->
<div class="row g-4 mb-5">
    <?php
    $stats = [
        ['Total Areas', 'map-location-dot', 'indigo', '5', 'up'],
        ['Active Residents', 'users', 'pink', '5', 'up'],
        ['Cultural Entities', 'building-columns', 'emerald', '4', 'steady'],
        ['Global Reach', 'earth-americas', 'rose', '11', 'up']
    ];
    foreach($stats as $stat): ?>
    <div class="col-md-3">
        <div class="kpi-card h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div class="icon-box bg-<?php echo $stat[2]; ?>-soft text-<?php echo $stat[2]; ?>">
                    <i class="fas fa-<?php echo $stat[1]; ?>"></i>
                </div>
                <?php if($stat[4] == 'up'): ?>
                    <span class="badge bg-success-soft text-success rounded-pill px-3 py-1 small fw-bold">
                        <i class="fas fa-arrow-up me-1"></i> Growth
                    </span>
                <?php else: ?>
                    <span class="badge bg-light text-muted rounded-pill px-3 py-1 small fw-bold">Stable</span>
                <?php endif; ?>
            </div>
            <div class="mt-3">
                <h3 class="fw-800 mb-1"><?php echo $stat[3]; ?></h3>
                <div class="text-muted small fw-bold text-uppercase letter-spacing-1"><?php echo $stat[0]; ?></div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="row g-4 mb-5">
    <!-- TREND ANALYSIS -->
    <div class="col-lg-8">
        <div class="glass p-5 rounded-4 border-0 shadow-sm h-100">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h4 class="fw-800 mb-0">Cultural Participation</h4>
                <div class="btn-group">
                    <button class="btn btn-sm btn-light active px-3">Weekly</button>
                    <button class="btn btn-sm btn-light px-3">Monthly</button>
                </div>
            </div>
            <div class="chart-container" style="height: 300px; display: flex; align-items: flex-end; justify-content: space-between; gap: 20px;">
                <?php 
                $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                $heights = [45, 70, 50, 95, 80, 55, 85];
                foreach($days as $i => $day): ?>
                <div class="flex-grow-1 d-flex flex-column align-items-center">
                    <div class="w-100 rounded-pill bg-light position-relative overflow-hidden" style="height: <?php echo $heights[$i]; ?>%; min-width: 28px;">
                        <div class="position-absolute bottom-0 w-100 bg-primary" style="height: 60%; opacity: 0.9; border-radius: 20px;"></div>
                    </div>
                    <span class="smaller text-muted fw-bold mt-3"><?php echo $day; ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- ACTIVITY LOG -->
    <div class="col-lg-4">
        <div class="glass p-5 rounded-4 border-0 shadow-sm h-100">
            <h4 class="fw-800 mb-4">Latest Pulses</h4>
            <div class="activity-feed">
                <?php
                $activities = [
                    ['Resident Joined', 'Alice J. linked to Central', '1m ago', 'user-plus', 'primary'],
                    ['New Feedback', 'High satisfaction score', '12m ago', 'star', 'warning'],
                    ['Entity Verified', 'Lumina Art Collective', '45m ago', 'certificate', 'indigo'],
                    ['Offering Live', 'Traditional Weaving', '2h ago', 'tag', 'emerald']
                ];
                foreach($activities as $act): ?>
                <div class="d-flex gap-3 mb-4">
                    <div class="avatar-sm bg-<?php echo $act[4]; ?>-soft text-<?php echo $act[4]; ?> rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" style="width: 42px; height: 42px;">
                        <i class="fas fa-<?php echo $act[3]; ?> small"></i>
                    </div>
                    <div>
                        <div class="fw-bold smaller text-dark"><?php echo $act[0]; ?></div>
                        <div class="text-muted smaller mb-1"><?php echo $act[1]; ?></div>
                        <div class="text-primary smaller fw-bold"><?php echo $act[2]; ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <button class="btn btn-light w-100 mt-3 py-2 rounded-3 small fw-bold">System Log <i class="fas fa-chevron-right ms-2 small"></i></button>
        </div>
    </div>
</div>

<!-- ADMINISTRATIVE GRID -->
<h4 class="fw-800 mb-4">Registry Management</h4>
<div class="row g-4">
    <div class="col-md-3">
        <a href="admin/list_areas.php" class="text-decoration-none">
            <div class="glass p-4 rounded-4 hover-lift border-0 shadow-sm h-100">
                <div class="icon-sm bg-success-soft text-success mb-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-map-location-dot"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">Area Registry</h5>
                <p class="smaller text-muted mb-0">Spatial data management</p>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="admin/list_residents.php" class="text-decoration-none">
            <div class="glass p-4 rounded-4 hover-lift border-0 shadow-sm h-100">
                <div class="icon-sm bg-primary-soft text-primary mb-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-users"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">Resident Hub</h5>
                <p class="smaller text-muted mb-0">Profile & access control</p>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="admin/list_offerings.php" class="text-decoration-none">
            <div class="glass p-4 rounded-4 hover-lift border-0 shadow-sm h-100">
                <div class="icon-sm bg-warning-soft text-warning mb-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-boxes-stacked"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">Offering Suite</h5>
                <p class="smaller text-muted mb-0">Cultural asset registry</p>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="analytics.php" class="text-decoration-none">
            <div class="glass p-4 rounded-4 hover-lift border-0 shadow-sm h-100">
                <div class="icon-sm bg-danger-soft text-danger mb-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <h5 class="fw-bold text-dark mb-1">Growth Data</h5>
                <p class="smaller text-muted mb-0">Predictive analytics</p>
            </div>
        </a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>