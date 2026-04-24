<?php
$page_title = "Add Cultural Offering";
include '../includes/header.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$message = "";
$companies_result = $conn->query("SELECT * FROM companies ORDER BY company_name");

if (isset($_POST['add_offering'])) {
    $product_name = trim($_POST['product_name']);
    $company_id = (int)$_POST['company_id'];
    $category = $_POST['category'];
    $type = $_POST['type'];
    $description = trim($_POST['description']);

    if (!empty($product_name) && $company_id > 0) {
        $stmt = $conn->prepare("INSERT INTO products (product_name, company_id, category, type, description) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sisss", $product_name, $company_id, $category, $type, $description);

        if ($stmt->execute()) {
            echo "<script>window.location.href='list_offerings.php?msg=added';</script>";
            exit();
        } else {
            $message = "Failed to add offering.";
        }
    } else {
        $message = "Offering name and provider are required.";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-800 mb-0">New Cultural Offering</h2>
            <a href="list_offerings.php" class="btn btn-outline-dark px-4 rounded-3">Back to List</a>
        </div>

        <?php if($message): ?>
            <div class="alert alert-danger border-0 shadow-sm mb-4"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="glass p-5 rounded-4 border-0 shadow-sm">
            <form method="POST">
                <div class="row g-4">
                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-uppercase text-muted">Offering Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-box-open small"></i></span>
                            <input type="text" name="product_name" class="form-control bg-light border-0 py-3" placeholder="e.g. Traditional Pottery Workshop" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-uppercase text-muted">Provider (Entity)</label>
                        <select name="company_id" class="form-select bg-light border-0 py-3" required>
                            <option value="">Select provider...</option>
                            <?php while($company = $companies_result->fetch_assoc()): ?>
                                <option value="<?php echo $company['id']; ?>"><?php echo $company['company_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-uppercase text-muted">Category</label>
                        <select name="category" class="form-select bg-light border-0 py-3">
                            <option>Arts</option>
                            <option>Music</option>
                            <option>Drama</option>
                            <option>Crafts</option>
                            <option>Heritage</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-uppercase text-muted">Offering Type</label>
                        <div class="d-flex gap-4 p-3 bg-light rounded-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="typeProduct" value="product" checked>
                                <label class="form-check-label fw-bold" for="typeProduct">Physical Product</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="typeService" value="service">
                                <label class="form-check-label fw-bold" for="typeService">Cultural Service</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-uppercase text-muted">Description</label>
                        <textarea name="description" class="form-control bg-light border-0 py-3" rows="4" placeholder="Detail the cultural significance..."></textarea>
                    </div>

                    <div class="col-md-12 mt-5">
                        <div class="d-flex gap-2">
                            <button type="submit" name="add_offering" class="btn btn-purple px-5 py-3 fw-bold shadow-lg flex-grow-1">Add Offering <i class="fas fa-plus ms-2"></i></button>
                            <a href="list_offerings.php" class="btn btn-light px-4 py-3 fw-bold border">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>