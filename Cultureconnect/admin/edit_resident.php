<?php
$page_title = "Edit Resident Profile";
include '../includes/header.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: list_residents.php");
    exit();
}

$id = (int)$_GET['id'];
$message = "";

$stmt = $conn->prepare("
    SELECT residents.*, users.full_name, users.email 
    FROM residents 
    JOIN users ON residents.user_id = users.id 
    WHERE residents.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: list_residents.php");
    exit();
}

$resident = $result->fetch_assoc();
$areas_result = $conn->query("SELECT * FROM areas ORDER BY area_name");

if (isset($_POST['update_resident'])) {
    $full_name = trim($_POST['full_name']);
    $area_id = (int)$_POST['area_id'];
    $phone = trim($_POST['phone']);

    if (!empty($full_name)) {
        $conn->begin_transaction();
        try {
            $update1 = $conn->prepare("UPDATE users SET full_name = ? WHERE id = ?");
            $update1->bind_param("si", $full_name, $resident['user_id']);
            $update1->execute();

            $update2 = $conn->prepare("UPDATE residents SET area_id = ?, phone = ? WHERE id = ?");
            $update2->bind_param("isi", $area_id, $phone, $id);
            $update2->execute();

            $conn->commit();
            echo "<script>window.location.href='list_residents.php?msg=updated';</script>";
            exit();
        } catch (Exception $e) {
            $conn->rollback();
            $message = "Update failed: " . $e->getMessage();
        }
    } else {
        $message = "Full name is required.";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-800 mb-0">Edit Resident</h2>
            <a href="list_residents.php" class="btn btn-outline-dark px-4 rounded-3">Back to List</a>
        </div>

        <?php if($message): ?>
            <div class="alert alert-danger border-0 shadow-sm mb-4"><?php echo $message; ?></div>
        <?php endif; ?>

        <div class="glass p-5 rounded-4 border-0 shadow-sm">
            <form method="POST">
                <div class="row g-4">
                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-uppercase text-muted">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-user small"></i></span>
                            <input type="text" name="full_name" class="form-control bg-light border-0 py-3" 
                                   value="<?php echo htmlspecialchars($resident['full_name']); ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-uppercase text-muted">Email Address (Non-editable)</label>
                        <input type="text" class="form-control bg-light border-0 py-3" value="<?php echo $resident['email']; ?>" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-uppercase text-muted">Residential Area</label>
                        <select name="area_id" class="form-select bg-light border-0 py-3" required>
                            <?php while($area = $areas_result->fetch_assoc()): ?>
                                <option value="<?php echo $area['id']; ?>" <?php echo $area['id'] == $resident['area_id'] ? 'selected' : ''; ?>>
                                    <?php echo $area['area_name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-uppercase text-muted">Phone Number</label>
                        <input type="text" name="phone" class="form-control bg-light border-0 py-3" value="<?php echo htmlspecialchars($resident['phone']); ?>">
                    </div>

                    <div class="col-md-12 mt-5">
                        <div class="d-flex gap-2">
                            <button type="submit" name="update_resident" class="btn btn-purple px-5 py-3 fw-bold shadow-lg flex-grow-1">Update Profile <i class="fas fa-check ms-2"></i></button>
                            <a href="list_residents.php" class="btn btn-light px-4 py-3 fw-bold border">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>