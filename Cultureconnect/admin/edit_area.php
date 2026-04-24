<?php
$page_title = "Edit Area";
include '../includes/header.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: list_areas.php");
    exit();
}

$id = (int)$_GET['id'];
$message = "";

$stmt = $conn->prepare("SELECT * FROM areas WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: list_areas.php");
    exit();
}

$area = $result->fetch_assoc();

if (isset($_POST['update_area'])) {
    $area_name = trim($_POST['area_name']);

    if (!empty($area_name)) {
        $update = $conn->prepare("UPDATE areas SET area_name = ? WHERE id = ?");
        $update->bind_param("si", $area_name, $id);

        if ($update->execute()) {
            echo "<script>window.location.href='list_areas.php?msg=updated';</script>";
            exit();
        } else {
            $message = "Failed to update area.";
        }
    } else {
        $message = "Area name is required.";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-800 mb-0">Edit Area</h2>
            <a href="list_areas.php" class="btn btn-outline-dark px-4 rounded-3">Back to List</a>
        </div>

        <?php if($message): ?>
            <div class="alert alert-danger border-0 shadow-sm mb-4"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="glass p-5 rounded-4 border-0 shadow-sm">
            <form method="POST">
                <div class="mb-4">
                    <label class="form-label small fw-bold text-uppercase text-muted">Area Name</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fas fa-map-marker-alt small"></i></span>
                        <input type="text" name="area_name" class="form-control bg-light border-0 py-3" 
                               value="<?php echo htmlspecialchars($area['area_name']); ?>" required>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" name="update_area" class="btn btn-purple px-5 py-3 fw-bold shadow-lg flex-grow-1">Update Area <i class="fas fa-check ms-2"></i></button>
                    <a href="list_areas.php" class="btn btn-light px-4 py-3 fw-bold border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>