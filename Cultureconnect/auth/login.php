<?php
include '../includes/db.php';
include '../includes/config.php';

$message = "";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, full_name, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];
            header("Location: ../dashboard.php");
            exit();
        } else {
            $message = "Invalid password.";
        }
    } else {
        $message = "User not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | CultureConnect</title>

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
                <h1 class="display-4 fw-800 mb-4">Welcome Back.</h1>
                <p class="h5 fw-light opacity-75">Sign in to continue discovering and supporting your local cultural community.</p>
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
                    <h2 class="fw-800">Login to account</h2>
                    <p class="text-muted">Enter your credentials to access your portal.</p>
                </div>

                <?php if($message): ?>
                    <div class="alert alert-danger border-0 shadow-sm mb-4"><?php echo $message; ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-uppercase text-muted">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-envelope small"></i></span>
                            <input type="email" id="loginEmail" name="email" class="form-control bg-light border-0 py-3" placeholder="name@example.com" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between">
                            <label class="form-label small fw-bold text-uppercase text-muted">Password</label>
                            <a href="#" class="small text-primary text-decoration-none fw-bold">Forgot?</a>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-lock small"></i></span>
                            <input type="password" id="loginPassword" name="password" class="form-control bg-light border-0 py-3" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="mb-4 d-flex align-items-center">
                        <input type="checkbox" id="remember" class="form-check-input me-2">
                        <label for="remember" class="small text-muted">Remember me for 30 days</label>
                    </div>

                    <button type="submit" name="login" class="btn btn-purple w-100 py-3 fw-bold shadow-lg">Login <i class="fas fa-sign-in-alt ms-2"></i></button>

                    <div class="mt-4 pt-3 border-top">
                        <p class="small text-muted mb-2 text-center">Quick Access for Demo:</p>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light btn-sm flex-grow-1 border fw-600" onclick="autofill('Admin@gmail.com', 'Admin123')">Demo Admin</button>
                            <button type="button" class="btn btn-light btn-sm flex-grow-1 border fw-600" onclick="autofill('resident1@example.com', 'resident123')">Demo Resident</button>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <p class="text-muted small">Don't have an account? <a href="signup.php" class="fw-bold text-primary">Create one here</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function autofill(email, pass) {
            document.getElementById('loginEmail').value = email;
            document.getElementById('loginPassword').value = pass;
        }
    </script>

</body>
</html>