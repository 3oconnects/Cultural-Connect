<?php
$page_title = "Discovery Feed";
include 'includes/header.php';
?>

<div class="mb-5">
    <h2 class="fw-800">Discovery Feed</h2>
    <p class="text-muted">Discover the latest cultural offerings in your community.</p>
</div>

<div class="row g-4">
    <?php
    $result = $conn->query("
        SELECT products.*, companies.company_name, areas.area_name 
        FROM products 
        JOIN companies ON products.company_id = companies.id 
        JOIN areas ON companies.area_id = areas.id
        ORDER BY RAND() LIMIT 12
    ");
    while($row = $result->fetch_assoc()): ?>
    <div class="col-md-4">
        <div class="glass p-0 rounded-4 overflow-hidden hover-lift h-100 border-0 shadow-sm">
            <div class="p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge bg-indigo-soft text-indigo px-3 py-2 rounded-pill small"><?php echo $row['category']; ?></span>
                    <div class="text-muted small"><i class="fas fa-map-marker-alt me-1"></i> <?php echo $row['area_name']; ?></div>
                </div>
                <h5 class="fw-800 mb-2"><?php echo $row['product_name']; ?></h5>
                <p class="small text-muted mb-4"><?php echo $row['description']; ?></p>
                <div class="pt-3 border-top d-flex justify-content-between align-items-center">
                    <div class="small fw-bold text-dark"><?php echo $row['company_name']; ?></div>
                    <button class="btn btn-purple btn-sm px-3 rounded-pill">Vote <i class="fas fa-heart ms-1"></i></button>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>

<?php include 'includes/footer.php'; ?>
