<?php
include 'db_connection.php';

$loginError = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if (empty($email) || empty($password)) {
            throw new Exception("Please enter both email and password.");
        }

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            throw new Exception("Invalid email or password.");
        }

        // Login successful
        session_start();
        $_SESSION['user_id'] = $user;
        header("Location: index.php");
        exit();

    } catch (Exception $e) {
        $loginError = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Email Sender</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #f1f3f6, #e9ecef);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            padding: 35px;
            border-radius: 16px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }
        .input-group-text {
            background-color: #e9ecef;
            border-radius: 8px 0 0 8px;
        }
        .form-control {
            border-radius: 0 8px 8px 0;
        }
        .btn-login {
            background-color: #4e73df;
            border: none;
            border-radius: 8px;
            padding: 10px;
            font-weight: 600;
            text-transform: uppercase;
            transition: 0.3s;
        }
        .btn-login:hover {
            background-color: #3c5cc5;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="col-md-6 col-lg-5">
            <div class="card">
                <div class="text-center mb-4">
                    <i class="fas fa-lock fa-3x text-primary mb-3"></i>
                    <h2>Login</h2>
                    <p class="text-muted">Access your dashboard</p>
                </div>

                <?php if (!empty($loginError)): ?>
                    <div class="alert alert-danger">❌ <?php echo htmlspecialchars($loginError); ?></div>
                <?php endif; ?>

                <form method="post" action="">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" id="email" required placeholder="Your email">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                            <input type="password" name="password" class="form-control" id="password" required placeholder="Your password">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login w-100">Login</button>
                </form>

                <p class="text-center text-muted mt-4">
                    Don’t have an account? <a href="register.php">Register here</a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
