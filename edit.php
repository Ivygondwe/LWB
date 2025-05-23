<?php
define('ROOT', dirname(__DIR__, 1));
require_once ROOT . '/config/db.php';
require_once ROOT . '/includes/header.php';

// Check if ID exists
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php?error=invalid_id");
    exit();
}

// Fetch existing customer data
$stmt = $pdo->prepare("SELECT * FROM customers WHERE id = ?");
$stmt->execute([$_GET['id']]);
$customer = $stmt->fetch();

if (!$customer) {
    header("Location: index.php?error=customer_not_found");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    
    // Validate required fields
    if (empty($_POST['customer_name'])) $errors[] = "Customer name is required";
    if (empty($_POST['account_number'])) $errors[] = "Account number is required";
    
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("UPDATE customers SET 
                customer_name = ?,
                address = ?,
                phone_number = ?,
                account_number = ?,
                area = ?,
                category = ?,
                water_sources = ?,
                connection_date = ?
                WHERE id = ?");
            
            $stmt->execute([
                $_POST['customer_name'],
                $_POST['address'],
                $_POST['phone_number'] ?? null,
                $_POST['account_number'],
                $_POST['area'],
                $_POST['category'],
                isset($_POST['water_sources']) ? implode(', ', $_POST['water_sources']) : null,
                $_POST['connection_date'] ?? null,
                $_GET['id']
            ]);
            
            header("Location: index.php?success=updated");
            exit();
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">
                <i class="bi bi-pencil-square"></i> 
                Edit Customer: <?= htmlspecialchars($customer['customer_name']) ?>
            </h4>
        </div>
        
        <div class="card-body">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <h5>Please fix these errors:</h5>
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form method="post">
                <!-- Personal Details -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label required">Full Name</label>
                        <input type="text" name="customer_name" class="form-control" 
                               value="<?= htmlspecialchars($customer['customer_name']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" name="phone_number" class="form-control" 
                               value="<?= htmlspecialchars($customer['phone_number']) ?>">
                    </div>
                </div>
                
                <!-- Address -->
                <div class="mb-3">
                    <label class="form-label required">Address</label>
                    <textarea name="address" class="form-control" required><?= 
                        htmlspecialchars($customer['address']) ?></textarea>
                </div>
                
                <!-- Account Details -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label required">Account Number</label>
                        <input type="text" name="account_number" class="form-control" 
                               value="<?= htmlspecialchars($customer['account_number']) ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label required">Area</label>
                        <input type="text" name="area" class="form-control" 
                               value="<?= htmlspecialchars($customer['area']) ?>" required>
                    </div>
                </div>
                
                <!-- Category -->
                <div class="mb-3">
                    <label class="form-label required">Customer Category</label>
                    <select name="category" class="form-select" required>
                        <option value="Residential" <?= $customer['category'] === 'Residential' ? 'selected' : '' ?>>Residential</option>
                        <option value="Commercial" <?= $customer['category'] === 'Commercial' ? 'selected' : '' ?>>Commercial</option>
                        <option value="Institutional" <?= $customer['category'] === 'Institutional' ? 'selected' : '' ?>>Institutional</option>
                        <option value="LWB Staff" <?= $customer['category'] === 'LWB Staff' ? 'selected' : '' ?>>LWB Staff</option>
                    </select>
                </div>
                
                <!-- Water Sources -->
                <div class="mb-3">
                    <label class="form-label">Water Sources</label>
                    <?php
                    $sources = $customer['water_sources'] ? explode(', ', $customer['water_sources']) : [];
                    ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="water_sources[]" value="Taps" id="taps" 
                            <?= in_array('Taps', $sources) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="taps">Taps</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="water_sources[]" value="Kiosk" id="kiosk"
                            <?= in_array('Kiosk', $sources) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="kiosk">Kiosk</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="water_sources[]" value="Overhead Tank" id="tank"
                            <?= in_array('Overhead Tank', $sources) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="tank">Overhead Tank</label>
                    </div>
                </div>
                
                <!-- Connection Date -->
                <div class="mb-3">
                    <label class="form-label">Connection Date</label>
                    <input type="date" name="connection_date" class="form-control" 
                           value="<?= htmlspecialchars($customer['connection_date']) ?>">
                </div>
                
                <!-- Form Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Save Changes
                    </button>
                    <a href="view.php?id=<?= $customer['id'] ?>" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once ROOT . '/includes/footer.php'; ?>