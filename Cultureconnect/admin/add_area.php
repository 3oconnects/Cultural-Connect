<?php
$page_title = "Add Area";
include '../includes/header.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$message = "";

if (isset($_POST['add_area'])) {
    $area_name = trim($_POST['area_name']);

    if (!empty($area_name)) {
        $stmt = $conn->prepare("INSERT INTO areas (area_name) VALUES (?)");
        $stmt->bind_param("s", $area_name);

        if ($stmt->execute()) {
            echo "<script>window.location.href='list_areas.php?msg=added';</script>";
            exit();
        } else {
            $message = "Failed to add area.";
        }
    } else {
        $message = "Area name is required.";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-800 mb-0">New Area</h2>
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
                        <span class="input-group-text bg-light border-0"><i class="fas fa-plus small"></i></span>
                        <input type="text" name="area_name" class="form-control bg-light border-0 py-3" 
                               placeholder="e.g. Downtown" required>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" name="add_area" class="btn btn-purple px-5 py-3 fw-bold shadow-lg flex-grow-1">Create Area <i class="fas fa-plus ms-2"></i></button>
                    <a href="list_areas.php" class="btn btn-light px-4 py-3 fw-bold border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>