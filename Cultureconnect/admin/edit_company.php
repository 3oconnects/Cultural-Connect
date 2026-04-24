<?php
$page_title = "Edit Entity";
include '../includes/header.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: list_companies.php");
    exit();
}

$id = (int)$_GET['id'];
$message = "";

$stmt = $conn->prepare("SELECT * FROM companies WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: list_companies.php");
    exit();
}

$company = $result->fetch_assoc();
$areas_result = $conn->query("SELECT * FROM areas ORDER BY area_name");

if (isset($_POST['update_company'])) {
    $company_name = trim($_POST['company_name']);
    $area_id = (int)$_POST['area_id'];
    $description = trim($_POST['description']);

    if (!empty($company_name) && $area_id > 0) {
        $update = $conn->prepare("UPDATE companies SET company_name = ?, area_id = ?, description = ? WHERE id = ?");
        $update->bind_param("sisi", $company_name, $area_id, $description, $id);

        if ($update->execute()) {
            echo "<script>window.location.href='list_companies.php?msg=updated';</script>";
            exit();
        } else {
            $message = "Failed to update entity.";
        }
    } else {
        $message = "Entity name and location are required.";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-800 mb-0">Edit Entity</h2>
            <a href="list_companies.php" class="btn btn-outline-dark px-4 rounded-3">Back to List</a>
        </div>

        <?php if($message): ?>
            <div class="alert alert-danger border-0 shadow-sm mb-4"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="glass p-5 rounded-4 border-0 shadow-sm">
            <form method="POST">
                <div class="row g-4">
                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-uppercase text-muted">Entity Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-building small"></i></span>
                            <input type="text" name="company_name" class="form-control bg-light border-0 py-3" 
                                   value="<?php echo htmlspecialchars($company['company_name']); ?>" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-uppercase text-muted">Location (Area)</label>
                        <select name="area_id" class="form-select bg-light border-0 py-3" required>
                            <?php while($area = $areas_result->fetch_assoc()): ?>
                                <option value="<?php echo $area['id']; ?>" <?php echo $area['id'] == $company['area_id'] ? 'selected' : ''; ?>>
                                    <?php echo $area['area_name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-uppercase text-muted">Description</label>
                        <textarea name="description" class="form-control bg-light border-0 py-3" rows="4"><?php echo htmlspecialchars($company['description']); ?></textarea>
                    </div>

                    <div class="col-md-12 mt-5">
                        <div class="d-flex gap-2">
                            <button type="submit" name="update_company" class="btn btn-purple px-5 py-3 fw-bold shadow-lg flex-grow-1">Update Entity <i class="fas fa-check ms-2"></i></button>
                            <a href="list_companies.php" class="btn btn-light px-4 py-3 fw-bold border">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>