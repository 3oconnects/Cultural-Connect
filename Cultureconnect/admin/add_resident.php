<?php
$page_title = "Onboard Resident";
include '../includes/header.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$message = "";
$areas_result = $conn->query("SELECT * FROM areas ORDER BY area_name");

if (isset($_POST['add_resident'])) {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $area_id = (int)$_POST['area_id'];
    $phone = trim($_POST['phone']);

    // Check if email exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        $message = "Email already registered.";
    } else {
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
            $message = "Registration failed: " . $e->getMessage();
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-800 mb-0">Onboard Resident</h2>
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
                            <input type="text" name="full_name" class="form-control bg-light border-0 py-3" placeholder="e.g. Alice Johnson" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-uppercase text-muted">Email Address</label>
                        <input type="email" name="email" class="form-control bg-light border-0 py-3" placeholder="alice@example.com" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-uppercase text-muted">Initial Password</label>
                        <input type="password" name="password" class="form-control bg-light border-0 py-3" placeholder="••••••••" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-uppercase text-muted">Residential Area</label>
                        <select name="area_id" class="form-select bg-light border-0 py-3" required>
                            <option value="">Select area...</option>
                            <?php while($area = $areas_result->fetch_assoc()): ?>
                                <option value="<?php echo $area['id']; ?>"><?php echo $area['area_name']; ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-uppercase text-muted">Phone Number</label>
                        <input type="text" name="phone" class="form-control bg-light border-0 py-3" placeholder="+1 234 567 890">
                    </div>

                    <div class="col-md-12 mt-5">
                        <div class="d-flex gap-2">
                            <button type="submit" name="add_resident" class="btn btn-purple px-5 py-3 fw-bold shadow-lg flex-grow-1">Onboard Resident <i class="fas fa-user-plus ms-2"></i></button>
                            <a href="list_residents.php" class="btn btn-light px-4 py-3 fw-bold border">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>