<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: ../customers/index.php");
    exit();
}

// Sample valid credentials (replace with DB check later)
$valid_user = "admin";
$valid_pass = "lwb@2024";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['username'] === $valid_user && $_POST['password'] === $valid_pass) {
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = $valid_user;
        header("Location: ../customers/index.php");
        exit();
    } else {
        $error = "Invalid credentials";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>LWB - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>LWB System Login</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
