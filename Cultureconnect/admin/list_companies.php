<?php
$page_title = "Cultural Entities";
include '../includes/header.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$areas_result = $conn->query("SELECT * FROM areas ORDER BY area_name");

// HANDLE MODAL SUBMISSION
if (isset($_POST['save_company'])) {
    $company_name = trim($_POST['company_name']);
    $area_id = (int)$_POST['area_id'];
    $description = trim($_POST['description']);

    if (!empty($company_name)) {
        $stmt = $conn->prepare("INSERT INTO companies (company_name, area_id, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $company_name, $area_id, $description);
        if ($stmt->execute()) {
            echo "<script>window.location.href='list_companies.php?msg=added';</script>";
            exit();
        }
    }
}

$result = $conn->query("
    SELECT companies.id, companies.company_name, companies.description, areas.area_name 
    FROM companies 
    JOIN areas ON companies.area_id = areas.id
    ORDER BY companies.id DESC
");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-800 mb-0">Cultural Entities</h2>
    <button type="button" class="btn btn-purple px-4 rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#addCompanyModal">
        <i class="fas fa-plus me-2"></i> Register Entity
    </button>
</div>

<?php if(isset($_GET['msg']) && $_GET['msg'] == 'added'): ?>
    <div class="alert alert-success border-0 shadow-sm mb-4 animate-fade-in">
        <i class="fas fa-check-circle me-2"></i> New cultural entity successfully registered!
    </div>
<?php endif; ?>

<div class="glass rounded-4 overflow-hidden border shadow-sm">
    <table class="table table-hover mb-0">
        <thead class="bg-light">
            <tr>
                <th class="ps-4 py-3 text-muted text-uppercase small fw-bold">Entity Name</th>
                <th class="py-3 text-muted text-uppercase small fw-bold">Location</th>
                <th class="py-3 text-muted text-uppercase small fw-bold">Description</th>
                <th class="pe-4 py-3 text-center text-muted text-uppercase small fw-bold">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="align-middle">
                <td class="ps-4">
                    <div class="fw-bold"><?php echo $row['company_name']; ?></div>
                    <div class="small text-muted">ID: #<?php echo $row['id']; ?></div>
                </td>
                <td>
                    <span class="badge bg-indigo-soft text-indigo px-3 py-2 rounded-pill"><?php echo $row['area_name']; ?></span>
                </td>
                <td>
                    <div class="small text-muted text-truncate" style="max-width: 300px;"><?php echo $row['description']; ?></div>
                </td>
                <td class="pe-4 text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <a href="edit_company.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-sm rounded-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-3" onclick="confirmDelete('delete_company.php?id=<?php echo $row['id']; ?>')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- ADD COMPANY MODAL -->
<div class="modal fade" id="addCompanyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-800">Register New Entity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-uppercase text-muted">Entity Name</label>
                            <input type="text" name="company_name" class="form-control bg-light border-0 py-2" placeholder="e.g. Arts United" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-uppercase text-muted">Location (Area)</label>
                            <select name="area_id" class="form-select bg-light border-0 py-2" required>
                                <option value="">Select location...</option>
                                <?php while($a = $areas_result->fetch_assoc()): ?>
                                    <option value="<?php echo $a['id']; ?>"><?php echo $a['area_name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-uppercase text-muted">Description</label>
                            <textarea name="description" class="form-control bg-light border-0 py-2" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light px-4 fw-bold border" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="save_company" class="btn btn-purple px-4 fw-bold shadow-sm">Save Entity <i class="fas fa-check ms-2 small"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>