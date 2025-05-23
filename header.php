<!DOCTYPE html>
<html>
<head>
    <title>LWB Customer Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="images/logo.PNG " alt="Logo" style="height:40px; margin-right:10px;">
                LWB Customer Management System
            </a>
            <div class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <span class="navbar-text me-3">
                        Logged in as: <?= htmlspecialchars($_SESSION['username']) ?>
                    </span>
                    <a class="nav-link" href="../auth/logout.php">Logout</a>
                <?php else: ?>
                    <a class="nav-link" href="../auth/login.php"></a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container my-4">