<?php
include 'auth_check.php';
include 'db.php';

$message = "";
$user_id = $_SESSION['user_id'];

/* get resident id from logged-in user */
$resStmt = $conn->prepare("SELECT id FROM residents WHERE user_id = ?");
$resStmt->bind_param("i", $user_id);
$resStmt->execute();
$resResult = $resStmt->get_result();

if ($resResult->num_rows !== 1) {
    die("Resident profile not found.");
}

$resident = $resResult->fetch_assoc();
$resident_id = $resident['id'];

/* fetch products */
$products = $conn->query("
    SELECT p.id, p.product_name, p.type, c.company_name
    FROM products p
    JOIN companies c ON p.company_id = c.id
    ORDER BY p.product_name ASC
");

if (isset($_POST['submit_vote'])) {
    $product_id = $_POST['product_id'];

    if (!empty($product_id)) {
        $check = $conn->prepare("SELECT id FROM votes WHERE resident_id = ? AND product_id = ?");
        $check->bind_param("ii", $resident_id, $product_id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "<div class='alert alert-warning'>You have already voted for this product.</div>";
        } else {
            $stmt = $conn->prepare("INSERT INTO votes (resident_id, product_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $resident_id, $product_id);

            if ($stmt->execute()) {
                $message = "<div class='alert alert-success'>Vote submitted successfully.</div>";
            } else {
                $message = "<div class='alert alert-danger'>Failed to submit vote.</div>";
            }
        }
    } else {
        $message = "<div class='alert alert-danger'>Please select a product.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<?php include 'sidebar.php'; ?>

<div class="main-content">
    <div class="card-box mb-4">
        <h3>Vote for Products / Services</h3>
        <p class="mb-0">Select a product or service and cast your vote.</p>
    </div>

    <div class="card-box" style="max-width:600px;">
        <?php echo $message; ?>

        <form method="POST" name="voteForm" onsubmit="return validateVoteForm()">
            <div class="mb-3">
                <label class="form-label">Select Product / Service</label>
                <select name="product_id" class="form-select" required>
                    <option value="">-- Select Product / Service --</option>
                    <?php while($product = $products->fetch_assoc()): ?>
                        <option value="<?php echo $product['id']; ?>">
                            <?php echo htmlspecialchars($product['product_name']); ?>
                            (<?php echo htmlspecialchars($product['type']); ?> -
                            <?php echo htmlspecialchars($product['company_name']); ?>)
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" name="submit_vote" class="btn btn-purple w-100">Submit Vote</button>
        </form>
    </div>
</div>

<script src="assets/js/validation.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</body>
</html>