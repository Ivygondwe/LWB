<?php
define('ROOT', dirname(__DIR__, 1));
require_once ROOT . '/config/db.php';
require_once ROOT . '/includes/header.php';

$query = $_GET['query'] ?? '';
$results = [];

if (!empty($query)) {
    $search = "%$query%";
    $stmt = $pdo->prepare("SELECT * FROM customers 
                          WHERE customer_name LIKE ? 
                          OR account_number LIKE ?
                          OR area LIKE ?
                          OR address LIKE ?
                          ORDER BY customer_name ASC");
    $stmt->execute([$search, $search, $search, $search]);
    $results = $stmt->fetchAll();
}
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-search"></i> Search Results</h4>
        </div>
        
        <div class="card-body">
            <form method="get" class="mb-4">
                <div class="input-group">
                    <input type="text" name="query" class="form-control" 
                           value="<?= htmlspecialchars($query) ?>" 
                           placeholder="Search by name, account, or area">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </form>
            
            <?php if (empty($results)): ?>
                <div class="alert alert-info">
                    <?= empty($query) ? 'Enter a search term' : 'No customers found matching "' . htmlspecialchars($query) . '"' ?>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Account #</th>
                                <th>Area</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($results as $customer): ?>
                            <tr>
                                <td><?= htmlspecialchars($customer['customer_name']) ?></td>
                                <td><?= htmlspecialchars($customer['account_number']) ?></td>
                                <td><?= htmlspecialchars($customer['area']) ?></td>
                                <td>
                                    <a href="view.php?id=<?= $customer['id'] ?>" 
                                       class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php require_once ROOT . '/includes/footer.php'; ?>