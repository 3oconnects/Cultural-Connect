<?php
include '../includes/db.php';
include '../includes/config.php';

$message = "";

if (isset($_POST['signup'])) {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "Email already exists.";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, 'resident')");
            $stmt->bind_param("sss", $full_name, $email, $hashed_password);

            if ($stmt->execute()) {
                $user_id = $stmt->insert_id;
                $conn->query("INSERT INTO residents (user_id) VALUES ($user_id)");
                header("Location: login.php");
                exit();
            } else {
                $message = "Something went wrong.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account | CultureConnect</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="../assets/css/style.css?v=1.1" rel="stylesheet">
    <style>
        .auth-split {
            min-height: 100vh;
            display: flex;
        }
        .auth-image {
            flex: 1;
            background: linear-gradient(rgba(99, 102, 241, 0.8), rgba(236, 72, 153, 0.8)), url('../assets/img/hero-culture.png');
            background-size: cover;
            background-position: center;
            display: none;
        }
        @media (min-width: 992px) {
            .auth-image { display: block; }
        }
        .auth-form-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            padding: 40px;
        }
        .auth-box {
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>
<body>

    <div class="auth-split">
        <div class="auth-image d-flex align-items-center justify-content-center p-5">
            <div class="text-white text-center animate-up">
                <h1 class="display-4 fw-800 mb-4">Welcome to the Community.</h1>
                <p class="h5 fw-light opacity-75">Connect with local talent and shape the future of culture in your area.</p>
            </div>
        </div>
        
        <div class="auth-form-container animate-fade-in">
            <div class="auth-box">
                <div class="mb-5">
                    <div class="landing-logo d-flex align-items-center mb-3">
                        <div class="logo-icon bg-primary text-white p-2 rounded-3 me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 14px;">
                            <i class="fas fa-circle-nodes"></i>
                        </div>
                        <span class="fw-800 text-dark h5 mb-0">CultureConnect</span>
                    </div>
                    <h2 class="fw-800">Create your account</h2>
                    <p class="text-muted">Start your journey with us today.</p>
                </div>

                <?php if($message): ?>
                    <div class="alert alert-danger border-0 shadow-sm mb-4"><?php echo $message; ?></div>
                <?php endif; ?>

                <form method="POST" name="signupForm">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-user small"></i></span>
                            <input type="text" name="full_name" class="form-control bg-light border-0" placeholder="John Doe" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-envelope small"></i></span>
                            <input type="email" name="email" class="form-control bg-light border-0" placeholder="name@example.com" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Password</label>
                            <input type="password" name="password" class="form-control bg-light border-0" placeholder="••••••••" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-uppercase text-muted">Confirm</label>
                            <input type="password" name="confirm_password" class="form-control bg-light border-0" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" name="signup" class="btn btn-purple w-100 py-3 fw-bold mt-3 shadow-lg">Sign Up <i class="fas fa-arrow-right ms-2"></i></button>

                    <div class="mt-4 text-center">
                        <p class="text-muted small">Already have an account? <a href="login.php" class="fw-bold text-primary">Login here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>