<?php
$page_title = "Edit Cultural Offering";
include '../includes/header.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: list_offerings.php");
    exit();
}

$id = (int)$_GET['id'];
$message = "";

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: list_offerings.php");
    exit();
}

$product = $result->fetch_assoc();
$companies_result = $conn->query("SELECT * FROM companies ORDER BY company_name");

if (isset($_POST['update_offering'])) {
    $product_name = trim($_POST['product_name']);
    $company_id = (int)$_POST['company_id'];
    $category = $_POST['category'];
    $type = $_POST['type'];
    $description = trim($_POST['description']);

    if (!empty($product_name) && $company_id > 0) {
        $update = $conn->prepare("UPDATE products SET product_name = ?, company_id = ?, category = ?, type = ?, description = ? WHERE id = ?");
        $update->bind_param("sisssi", $product_name, $company_id, $category, $type, $description, $id);

        if ($update->execute()) {
            echo "<script>window.location.href='list_offerings.php?msg=updated';</script>";
            exit();
        } else {
            $message = "Failed to update offering.";
        }
    } else {
        $message = "Offering name and provider are required.";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-800 mb-0">Edit Offering</h2>
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
                            <input type="text" name="product_name" class="form-control bg-light border-0 py-3" 
                                   value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-uppercase text-muted">Provider (Entity)</label>
                        <select name="company_id" class="form-select bg-light border-0 py-3" required>
                            <?php while($company = $companies_result->fetch_assoc()): ?>
                                <option value="<?php echo $company['id']; ?>" <?php echo $company['id'] == $product['company_id'] ? 'selected' : ''; ?>>
                                    <?php echo $company['company_name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-uppercase text-muted">Category</label>
                        <select name="category" class="form-select bg-light border-0 py-3">
                            <?php $cats = ['Arts', 'Music', 'Drama', 'Crafts', 'Heritage']; 
                            foreach($cats as $cat): ?>
                                <option <?php echo $product['category'] == $cat ? 'selected' : ''; ?>><?php echo $cat; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-uppercase text-muted">Offering Type</label>
                        <div class="d-flex gap-4 p-3 bg-light rounded-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="typeProduct" value="product" <?php echo $product['type'] == 'product' ? 'checked' : ''; ?>>
                                <label class="form-check-label fw-bold" for="typeProduct">Physical Product</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" id="typeService" value="service" <?php echo $product['type'] == 'service' ? 'checked' : ''; ?>>
                                <label class="form-check-label fw-bold" for="typeService">Cultural Service</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-uppercase text-muted">Description</label>
                        <textarea name="description" class="form-control bg-light border-0 py-3" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>

                    <div class="col-md-12 mt-5">
                        <div class="d-flex gap-2">
                            <button type="submit" name="update_offering" class="btn btn-purple px-5 py-3 fw-bold shadow-lg flex-grow-1">Update Offering <i class="fas fa-check ms-2"></i></button>
                            <a href="list_offerings.php" class="btn btn-light px-4 py-3 fw-bold border">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>