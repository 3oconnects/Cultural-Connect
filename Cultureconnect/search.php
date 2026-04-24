<?php
include 'auth_check.php';
include 'db.php';

/* fetch companies for filter dropdown */
$companies = $conn->query("SELECT * FROM companies ORDER BY company_name ASC");

/* get search inputs */
$search_name = isset($_GET['search_name']) ? trim($_GET['search_name']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
$type = isset($_GET['type']) ? trim($_GET['type']) : '';
$company_id = isset($_GET['company_id']) ? trim($_GET['company_id']) : '';

/* base query */
$sql = "SELECT p.*, c.company_name
        FROM products p
        JOIN companies c ON p.company_id = c.id
        WHERE 1=1";

/* dynamic filters */
$params = [];
$types = "";

if (!empty($search_name)) {
    $sql .= " AND p.product_name LIKE ?";
    $params[] = "%" . $search_name . "%";
    $types .= "s";
}

if (!empty($category)) {
    $sql .= " AND p.category LIKE ?";
    $params[] = "%" . $category . "%";
    $types .= "s";
}

if (!empty($type)) {
    $sql .= " AND p.type = ?";
    $params[] = $type;
    $types .= "s";
}

if (!empty($company_id)) {
    $sql .= " AND p.company_id = ?";
    $params[] = $company_id;
    $types .= "i";
}

$sql .= " ORDER BY p.id DESC";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$results = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Products / Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="card-box">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Search Products / Services</h2>
            <a href="list_products.php" class="btn btn-outline-dark">View All Products</a>
        </div>

        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <label class="form-label">Search by Name</label>
                <input type="text" name="search_name" class="form-control"
                       value="<?php echo htmlspecialchars($search_name); ?>"
                       placeholder="Enter product name">
            </div>

            <div class="col-md-3">
                <label class="form-label">Category</label>
                <input type="text" name="category" class="form-control"
                       value="<?php echo htmlspecialchars($category); ?>"
                       placeholder="Enter category">
            </div>

            <div class="col-md-2">
                <label class="form-label">Type</label>
                <select name="type" class="form-select">
                    <option value="">-- All --</option>
                    <option value="Product" <?php if($type == 'Product') echo 'selected'; ?>>Product</option>
                    <option value="Service" <?php if($type == 'Service') echo 'selected'; ?>>Service</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Company</label>
                <select name="company_id" class="form-select">
                    <option value="">-- All --</option>
                    <?php while($company = $companies->fetch_assoc()): ?>
                        <option value="<?php echo $company['id']; ?>"
                            <?php if($company_id == $company['id']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($company['company_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-purple w-100">Search</button>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <a href="search.php" class="btn btn-secondary w-100">Reset</a>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Company</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($results->num_rows > 0): ?>
                        <?php while($row = $results->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['category']); ?></td>
                                <td><?php echo htmlspecialchars($row['type']); ?></td>
                                <td><?php echo htmlspecialchars($row['company_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['description']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No matching products / services found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>