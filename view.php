<?php
define('ROOT', dirname(__DIR__, 1));

require_once ROOT . '/config/db.php';
require_once ROOT . '/includes/header.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->execute([$_GET['id']]);
$customer = $stmt->fetch();

if (!$customer) {
    header("Location: index.php?error=notfound");
    exit();
}
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="bi bi-person-badge"></i> 
                Customer Details: <?= htmlspecialchars($customer['customer_name']) ?>
            </h4>
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>Basic Information</h5>
                    <p><strong>Account Number:</strong> <?= htmlspecialchars($customer['account_number']) ?></p>
                    <p><strong>Category:</strong> <?= htmlspecialchars($customer['category']) ?></p>
                    <p><strong>Area:</strong> <?= htmlspecialchars($customer['area']) ?></p>
                </div>
                
                <div class="col-md-6">
                    <h5>Contact Details</h5>
                    <p><strong>Address:</strong> <?= htmlspecialchars($customer['address']) ?></p>
                    <p><strong>Phone:</strong> <?= $customer['phone_number'] ? htmlspecialchars($customer['phone_number']) : 'N/A' ?></p>
                    <p><strong>Connection Date:</strong> <?= $customer['connection_date'] ?: 'N/A' ?></p>
                </div>
            </div>
            
            <div class="mt-4">
                <h5>Water Sources</h5>
                <p><?= $customer['water_sources'] ? htmlspecialchars($customer['water_sources']) : 'None specified' ?></p>
            </div>
            
            <div class="mt-4">
                <a href="index.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
                <a href="edit.php?id=<?= $customer['id'] ?>" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once ROOT . '/includes/footer.php'; ?>