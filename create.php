<?php
// Database connection
define('ROOT', dirname(__DIR__, 1));
require_once ROOT . '/config/db.php';

// Initialize form data
$formData = [
    'customer_name' => '',
    'phone_number' => '',
    'address' => '',
    'account_number' => '',
    'area' => '',
    'category' => '',
    'water_sources' => [],
    'connection_date' => ''
];
$errors = [];

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and store form data
    $formData = [
        'customer_name' => trim($_POST['customer_name'] ?? ''),
        'phone_number' => trim($_POST['phone_number'] ?? ''),
        'address' => trim($_POST['address'] ?? ''),
        'account_number' => trim($_POST['account_number'] ?? ''),
        'area' => trim($_POST['area'] ?? ''),
        'category' => $_POST['category'] ?? '',
        'water_sources' => $_POST['water_sources'] ?? [],
        'connection_date' => $_POST['connection_date'] ?? ''
    ];

    // Validate required fields
    if (empty($formData['customer_name'])) $errors[] = "Full name is required";
    if (empty($formData['account_number'])) $errors[] = "Account number is required";
    if (empty($formData['address'])) $errors[] = "Address is required";
    if (empty($formData['area'])) $errors[] = "Area is required";

    // Save to database if no errors
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO customers 
                (customer_name, address, phone_number, account_number, area, category, water_sources, connection_date)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            
            $stmt->execute([
                $formData['customer_name'],
                $formData['address'],
                $formData['phone_number'],
                $formData['account_number'],
                $formData['area'],
                $formData['category'],
                !empty($formData['water_sources']) ? implode(', ', $formData['water_sources']) : null,
                $formData['connection_date']
            ]);
            
            header("Location: index.php?success=1");
            exit();
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer - LWB System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #3498db;
            --secondary: #2980b9;
            --success: #27ae60;
            --danger: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            margin: 0;
        }
        
        .app-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar styles */
        .sidebar {
            width: 250px;
            background: var(--dark);
            color: white;
            padding: 20px 0;
        }
        
        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-menu {
            padding: 20px;
        }
        
        .menu-item {
            margin-bottom: 8px;
        }
        
        .menu-item a {
            display: block;
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.3s;
        }
        
        .menu-item a:hover {
            background: rgba(255,255,255,0.1);
        }
        
        .menu-item a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        /* Main content styles */
        .main-content {
            flex: 1;
            padding: 30px;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        /* Form styles */
        .form-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .form-label.required:after {
            content: " *";
            color: var(--danger);
        }
        
        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 15px;
        }
        
        textarea.form-control {
            min-height: 100px;
        }
        
        .form-row {
            display: flex;
            gap: 20px;
        }
        
        .form-row .form-group {
            flex: 1;
        }
        
        .checkbox-group {
            margin-top: 10px;
        }
        
        .checkbox-item {
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }
        
        .checkbox-item input {
            margin-right: 10px;
        }
        
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-success {
            background: var(--success);
            color: white;
            border: none;
        }
        
        .btn-outline {
            background: white;
            border: 1px solid #ced4da;
            color: var(--dark);
            text-decoration: none;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="app-container">
        <!-- Sidebar Navigation -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>LWB System</h2>
            </div>
            <nav class="sidebar-menu">
                <div class="menu-item">
                    <a href="index.php"><i class="fas fa-users"></i> Customers</a>
                </div>
                <div class="menu-item">
                    <a href="#"><i class="fas fa-file-invoice-dollar"></i> Billing</a>
                </div>
                <div class="menu-item">
                    <a href="#"><i class="fas fa-chart-line"></i> Reports</a>
                </div>
                <div class="menu-item">
                    <a href="#"><i class="fas fa-cog"></i> Settings</a>
                </div>
                <div class="menu-item">
                    <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <h1>Add New Customer</h1>
                <div class="user-info">
                    <span><?= htmlspecialchars($_SESSION['username'] ?? 'Admin') ?></span>
                    <div class="avatar"><?= strtoupper(substr($_SESSION['username'] ?? 'AD', 0, 2)) ?></div>
                </div>
            </div>

            <div class="form-card">
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <h4>Please fix these errors:</h4>
                        <ul>
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <!-- Customer Details -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label required">Full Name</label>
                            <input type="text" name="customer_name" class="form-control" 
                                   value="<?= htmlspecialchars($formData['customer_name']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Phone Number</label>
                            <input type="tel" name="phone_number" class="form-control" 
                                   value="<?= htmlspecialchars($formData['phone_number']) ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Address</label>
                        <textarea name="address" class="form-control" required><?= 
                            htmlspecialchars($formData['address']) ?></textarea>
                    </div>

                    <!-- Account Details -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label required">Account Number</label>
                            <input type="text" name="account_number" class="form-control" 
                                   value="<?= htmlspecialchars($formData['account_number']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label required">Area</label>
                            <input type="text" name="area" class="form-control" 
                                   value="<?= htmlspecialchars($formData['area']) ?>" required>
                        </div>
                    </div>

                    <!-- Category Selection -->
                    <div class="form-group">
                        <label class="form-label required">Customer Category</label>
                        <select name="category" class="form-control" required>
                            <option value="">-- Select Category --</option>
                            <option value="Residential" <?= $formData['category'] === 'Residential' ? 'selected' : '' ?>>Residential</option>
                            <option value="Commercial" <?= $formData['category'] === 'Commercial' ? 'selected' : '' ?>>Commercial</option>
                            <option value="Institutional" <?= $formData['category'] === 'Institutional' ? 'selected' : '' ?>>Institutional</option>
                            <option value="LWB Staff" <?= $formData['category'] === 'LWB Staff' ? 'selected' : '' ?>>LWB Staff</option>
                        </select>
                    </div>

                    <!-- Water Sources -->
                    <div class="form-group">
                        <label class="form-label">Water Sources</label>
                        <div class="checkbox-group">
                            <div class="checkbox-item">
                                <input type="checkbox" name="water_sources[]" value="Taps" id="taps" 
                                    <?= in_array('Taps', $formData['water_sources']) ? 'checked' : '' ?>>
                                <label for="taps">Taps</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" name="water_sources[]" value="Kiosk" id="kiosk"
                                    <?= in_array('Kiosk', $formData['water_sources']) ? 'checked' : '' ?>>
                                <label for="kiosk">Kiosk</label>
                            </div>
                            <div class="checkbox-item">
                                <input type="checkbox" name="water_sources[]" value="Overhead Tank" id="tank"
                                    <?= in_array('Overhead Tank', $formData['water_sources']) ? 'checked' : '' ?>>
                                <label for="tank">Overhead Tank</label>
                            </div>
                        </div>
                    </div>

                    <!-- Connection Date -->
                    <div class="form-group">
                        <label class="form-label">Connection Date</label>
                        <input type="date" name="connection_date" class="form-control" 
                               value="<?= htmlspecialchars($formData['connection_date']) ?>">
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="index.php" class="btn btn-outline">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> Save Customer
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
