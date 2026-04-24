<?php
$page_title = "Manage Areas";
include '../includes/header.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// HANDLE MODAL SUBMISSION
$message = "";
if (isset($_POST['save_area'])) {
    $area_name = trim($_POST['area_name']);
    if (!empty($area_name)) {
        $stmt = $conn->prepare("INSERT INTO areas (area_name) VALUES (?)");
        $stmt->bind_param("s", $area_name);
        if ($stmt->execute()) {
            echo "<script>window.location.href='list_areas.php?msg=added';</script>";
            exit();
        } else {
            $message = "Failed to save area.";
        }
    }
}

$result = $conn->query("SELECT * FROM areas ORDER BY id DESC");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-800 mb-0">Area Registry</h2>
    <button type="button" class="btn btn-purple px-4 rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#addAreaModal">
        <i class="fas fa-plus me-2"></i> Add New Area
    </button>
</div>

<?php if(isset($_GET['msg']) && $_GET['msg'] == 'added'): ?>
    <div class="alert alert-success border-0 shadow-sm mb-4 animate-fade-in">
        <i class="fas fa-check-circle me-2"></i> New area successfully registered in the community!
    </div>
<?php endif; ?>

<div class="glass rounded-4 overflow-hidden border shadow-sm">
    <table class="table table-hover mb-0">
        <thead class="bg-light">
            <tr>
                <th class="ps-4 py-3 text-muted text-uppercase small fw-bold">ID</th>
                <th class="py-3 text-muted text-uppercase small fw-bold">Area Name</th>
                <th class="pe-4 py-3 text-center text-muted text-uppercase small fw-bold">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="align-middle">
                <td class="ps-4 fw-bold">#<?php echo $row['id']; ?></td>
                <td><?php echo $row['area_name']; ?></td>
                <td class="pe-4 text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <a href="edit_area.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-sm rounded-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-3" onclick="confirmDelete('delete_area.php?id=<?php echo $row['id']; ?>')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- ADD AREA MODAL -->
<div class="modal fade" id="addAreaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-800">Register New Area</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body p-4">
                    <p class="text-muted smaller mb-4">Add a new geographical or cultural zone to the platform registry.</p>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Area Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-map-marked-alt small"></i></span>
                            <input type="text" name="area_name" class="form-control bg-light border-0 py-2" placeholder="e.g. North District" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light px-4 fw-bold border" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="save_area" class="btn btn-purple px-4 fw-bold shadow-sm">Save Area <i class="fas fa-check ms-2 small"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>