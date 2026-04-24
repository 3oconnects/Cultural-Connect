<?php
$page_title = "Community Analytics";
include 'includes/header.php';
?>

<div class="mb-5">
    <h2 class="fw-800">Community Analytics</h2>
    <p class="text-muted">Visualizing cultural participation across all areas.</p>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="glass p-4 rounded-4 shadow-sm h-100">
            <h5 class="fw-bold mb-4">Participation by Area</h5>
            <div class="chart-mockup bg-light rounded-4 d-flex align-items-end justify-content-around p-4" style="height: 300px;">
                <div class="bg-primary rounded-top" style="width: 40px; height: 80%;"></div>
                <div class="bg-indigo rounded-top" style="width: 40px; height: 60%;"></div>
                <div class="bg-success rounded-top" style="width: 40px; height: 90%;"></div>
                <div class="bg-warning rounded-top" style="width: 40px; height: 40%;"></div>
                <div class="bg-danger rounded-top" style="width: 40px; height: 70%;"></div>
            </div>
            <div class="d-flex justify-content-around mt-3 small text-muted fw-bold">
                <span>Central</span><span>North</span><span>South</span><span>East</span><span>West</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="glass p-4 rounded-4 shadow-sm h-100">
            <h5 class="fw-bold mb-4">Top Categories</h5>
            <div class="space-y-4">
                <?php
                $cats = [['Arts', 85, 'bg-primary'], ['Music', 72, 'bg-indigo'], ['Drama', 45, 'bg-success'], ['Crafts', 30, 'bg-warning']];
                foreach($cats as $cat): ?>
                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="small fw-bold"><?php echo $cat[0]; ?></span>
                        <span class="small text-muted"><?php echo $cat[1]; ?>%</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar <?php echo $cat[2]; ?>" style="width: <?php echo $cat[1]; ?>%"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
