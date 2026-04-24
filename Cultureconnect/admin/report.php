<?php
$page_title = "Cultural Impact Report";
include '../includes/header.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Analytics Queries
$total_residents = $conn->query("SELECT COUNT(*) as count FROM residents")->fetch_assoc()['count'];
$total_areas = $conn->query("SELECT COUNT(*) as count FROM areas")->fetch_assoc()['count'];
$total_entities = $conn->query("SELECT COUNT(*) as count FROM companies")->fetch_assoc()['count'];
$total_offerings = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc()['count'];

$area_stats = $conn->query("
    SELECT areas.area_name, COUNT(residents.id) as resident_count 
    FROM areas 
    LEFT JOIN residents ON areas.id = residents.area_id 
    GROUP BY areas.id
");
?>

<div class="d-flex justify-content-between align-items-center mb-5">
    <div>
        <h2 class="fw-800 mb-1">Impact Report</h2>
        <p class="text-muted mb-0">Aggregate data on community participation and cultural reach.</p>
    </div>
    <button class="btn btn-purple px-4 py-2 rounded-3" onclick="window.print()">
        <i class="fas fa-print me-2"></i> Print Report
    </button>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="glass p-4 rounded-4 border-0 shadow-sm text-center">
            <div class="h1 fw-800 text-primary mb-1"><?php echo $total_residents; ?></div>
            <div class="text-muted small fw-bold text-uppercase">Total Residents</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass p-4 rounded-4 border-0 shadow-sm text-center">
            <div class="h1 fw-800 text-indigo mb-1"><?php echo $total_areas; ?></div>
            <div class="text-muted small fw-bold text-uppercase">Active Areas</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass p-4 rounded-4 border-0 shadow-sm text-center">
            <div class="h1 fw-800 text-success mb-1"><?php echo $total_entities; ?></div>
            <div class="text-muted small fw-bold text-uppercase">Cultural Entities</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="glass p-4 rounded-4 border-0 shadow-sm text-center">
            <div class="h1 fw-800 text-warning mb-1"><?php echo $total_offerings; ?></div>
            <div class="text-muted small fw-bold text-uppercase">Offerings</div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="glass p-5 rounded-4 border-0 shadow-sm">
            <h5 class="fw-bold mb-4">Area Density Analysis</h5>
            <div class="space-y-4">
                <?php while($row = $area_stats->fetch_assoc()): 
                    $percent = $total_residents > 0 ? ($row['resident_count'] / $total_residents) * 100 : 0;
                ?>
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold"><?php echo $row['area_name']; ?></span>
                        <span class="text-muted"><?php echo $row['resident_count']; ?> Residents</span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-primary" style="width: <?php echo $percent; ?>%"></div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="glass p-5 rounded-4 border-0 shadow-sm">
            <h5 class="fw-bold mb-4">Recent Milestones</h5>
            <div class="list-group list-group-flush">
                <div class="list-group-item bg-transparent border-0 px-0 mb-3">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1 fw-bold">Platform Modernization</h6>
                        <small class="text-success">Completed</small>
                    </div>
                    <p class="mb-1 small text-muted">Migration to modular architecture and premium UI/UX system.</p>
                </div>
                <div class="list-group-item bg-transparent border-0 px-0 mb-3">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1 fw-bold">Database Port Stabilization</h6>
                        <small class="text-success">Completed</small>
                    </div>
                    <p class="mb-1 small text-muted">Secured database connectivity on port 3307 for local dev environments.</p>
                </div>
                <div class="list-group-item bg-transparent border-0 px-0">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1 fw-bold">Entity Expansion</h6>
                        <small class="text-primary">In Progress</small>
                    </div>
                    <p class="mb-1 small text-muted">Onboarding 5 new cultural partners for the upcoming festival season.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>