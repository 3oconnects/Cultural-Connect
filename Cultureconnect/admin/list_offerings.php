<?php
$page_title = "Cultural Offerings";
include '../includes/header.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$companies_result = $conn->query("SELECT * FROM companies ORDER BY company_name");

// HANDLE MODAL SUBMISSION
if (isset($_POST['save_offering'])) {
    $product_name = trim($_POST['product_name']);
    $company_id = (int)$_POST['company_id'];
    $category = $_POST['category'];
    $type = $_POST['type'];
    $description = trim($_POST['description']);

    if (!empty($product_name)) {
        $stmt = $conn->prepare("INSERT INTO products (product_name, company_id, category, type, description) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sisss", $product_name, $company_id, $category, $type, $description);
        if ($stmt->execute()) {
            echo "<script>window.location.href='list_offerings.php?msg=added';</script>";
            exit();
        }
    }
}

$result = $conn->query("
    SELECT products.id, products.product_name, products.category, products.type, companies.company_name 
    FROM products 
    JOIN companies ON products.company_id = companies.id
    ORDER BY products.id DESC
");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-800 mb-0">Cultural Offerings</h2>
    <button type="button" class="btn btn-purple px-4 rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#addOfferingModal">
        <i class="fas fa-plus me-2"></i> Add Offering
    </button>
</div>

<?php if(isset($_GET['msg']) && $_GET['msg'] == 'added'): ?>
    <div class="alert alert-success border-0 shadow-sm mb-4 animate-fade-in">
        <i class="fas fa-check-circle me-2"></i> Cultural offering successfully added to the registry!
    </div>
<?php endif; ?>

<div class="glass rounded-4 overflow-hidden border shadow-sm">
    <table class="table table-hover mb-0">
        <thead class="bg-light">
            <tr>
                <th class="ps-4 py-3 text-muted text-uppercase small fw-bold">Offering</th>
                <th class="py-3 text-muted text-uppercase small fw-bold">Category</th>
                <th class="py-3 text-muted text-uppercase small fw-bold">Provider</th>
                <th class="pe-4 py-3 text-center text-muted text-uppercase small fw-bold">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="align-middle">
                <td class="ps-4">
                    <div class="fw-bold"><?php echo $row['product_name']; ?></div>
                    <div class="small text-muted">ID: #<?php echo $row['id']; ?> | <span class="text-uppercase"><?php echo $row['type']; ?></span></div>
                </td>
                <td>
                    <span class="badge bg-success-soft text-success px-3 py-2 rounded-pill"><?php echo $row['category']; ?></span>
                </td>
                <td>
                    <div class="small fw-500 text-dark"><?php echo $row['company_name']; ?></div>
                </td>
                <td class="pe-4 text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <a href="edit_offering.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-sm rounded-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-3" onclick="confirmDelete('delete_offering.php?id=<?php echo $row['id']; ?>')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- ADD OFFERING MODAL -->
<div class="modal fade" id="addOfferingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-800">New Cultural Offering</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-uppercase text-muted">Offering Name</label>
                            <input type="text" name="product_name" class="form-control bg-light border-0 py-2" placeholder="e.g. Traditional Pottery" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted">Provider (Entity)</label>
                            <select name="company_id" class="form-select bg-light border-0 py-2" required>
                                <option value="">Select provider...</option>
                                <?php while($c = $companies_result->fetch_assoc()): ?>
                                    <option value="<?php echo $c['id']; ?>"><?php echo $c['company_name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted">Category</label>
                            <select name="category" class="form-select bg-light border-0 py-2">
                                <option>Arts</option>
                                <option>Music</option>
                                <option>Drama</option>
                                <option>Crafts</option>
                                <option>Heritage</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-uppercase text-muted">Offering Type</label>
                            <div class="d-flex gap-4 p-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="typeP" value="product" checked>
                                    <label class="form-check-label" for="typeP">Product</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="type" id="typeS" value="service">
                                    <label class="form-check-label" for="typeS">Service</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-uppercase text-muted">Description</label>
                            <textarea name="description" class="form-control bg-light border-0 py-2" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light px-4 fw-bold border" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="save_offering" class="btn btn-purple px-4 fw-bold shadow-sm">Save Offering <i class="fas fa-plus ms-2 small"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>