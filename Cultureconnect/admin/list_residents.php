<?php
$page_title = "Resident Directory";
include '../includes/header.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$areas_result = $conn->query("SELECT * FROM areas ORDER BY area_name");

// HANDLE MODAL SUBMISSION
if (isset($_POST['onboard_resident'])) {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $area_id = (int)$_POST['area_id'];
    $phone = trim($_POST['phone']);

    $conn->begin_transaction();
    try {
        $stmt1 = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, 'resident')");
        $stmt1->bind_param("sss", $full_name, $email, $password);
        $stmt1->execute();
        $user_id = $conn->insert_id;

        $stmt2 = $conn->prepare("INSERT INTO residents (user_id, area_id, phone) VALUES (?, ?, ?)");
        $stmt2->bind_param("iis", $user_id, $area_id, $phone);
        $stmt2->execute();

        $conn->commit();
        echo "<script>window.location.href='list_residents.php?msg=added';</script>";
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        $error = "Failed to onboard: " . $e->getMessage();
    }
}

$result = $conn->query("
    SELECT residents.id, users.full_name, users.email, areas.area_name, residents.phone 
    FROM residents 
    JOIN users ON residents.user_id = users.id 
    JOIN areas ON residents.area_id = areas.id
    ORDER BY residents.id DESC
");
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-800 mb-0">Resident Directory</h2>
    <button type="button" class="btn btn-purple px-4 rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#onboardModal">
        <i class="fas fa-user-plus me-2"></i> Onboard Resident
    </button>
</div>

<?php if(isset($_GET['msg']) && $_GET['msg'] == 'added'): ?>
    <div class="alert alert-success border-0 shadow-sm mb-4 animate-fade-in">
        <i class="fas fa-check-circle me-2"></i> Resident successfully onboarded to the platform!
    </div>
<?php endif; ?>

<div class="glass rounded-4 overflow-hidden border shadow-sm">
    <table class="table table-hover mb-0">
        <thead class="bg-light">
            <tr>
                <th class="ps-4 py-3 text-muted text-uppercase small fw-bold">Resident</th>
                <th class="py-3 text-muted text-uppercase small fw-bold">Contact</th>
                <th class="py-3 text-muted text-uppercase small fw-bold">Area</th>
                <th class="pe-4 py-3 text-center text-muted text-uppercase small fw-bold">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="align-middle">
                <td class="ps-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-sm bg-light text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 35px; height: 35px;">
                            <?php echo substr($row['full_name'], 0, 1); ?>
                        </div>
                        <div>
                            <div class="fw-bold"><?php echo $row['full_name']; ?></div>
                            <div class="small text-muted">ID: #<?php echo $row['id']; ?></div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="small fw-500"><?php echo $row['email']; ?></div>
                    <div class="small text-muted"><?php echo $row['phone']; ?></div>
                </td>
                <td>
                    <span class="badge bg-indigo-soft text-indigo px-3 py-2 rounded-pill"><?php echo $row['area_name']; ?></span>
                </td>
                <td class="pe-4 text-center">
                    <div class="d-flex justify-content-center gap-2">
                        <a href="edit_resident.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-sm rounded-3">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-outline-danger btn-sm rounded-3" onclick="confirmDelete('delete_resident.php?id=<?php echo $row['id']; ?>')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- ONBOARD MODAL -->
<div class="modal fade" id="onboardModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-800">Onboard New Resident</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST">
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label small fw-bold text-uppercase text-muted">Full Name</label>
                            <input type="text" name="full_name" class="form-control bg-light border-0 py-2" placeholder="e.g. Alice Johnson" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted">Email</label>
                            <input type="email" name="email" class="form-control bg-light border-0 py-2" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted">Initial Password</label>
                            <input type="password" name="password" class="form-control bg-light border-0 py-2" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted">Residential Area</label>
                            <select name="area_id" class="form-select bg-light border-0 py-2" required>
                                <option value="">Select area...</option>
                                <?php $areas_result->data_seek(0); while($a = $areas_result->fetch_assoc()): ?>
                                    <option value="<?php echo $a['id']; ?>"><?php echo $a['area_name']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-uppercase text-muted">Phone Number</label>
                            <input type="text" name="phone" class="form-control bg-light border-0 py-2">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light px-4 fw-bold border" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" name="onboard_resident" class="btn btn-purple px-4 fw-bold shadow-sm">Complete Onboarding <i class="fas fa-check-circle ms-2 small"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>