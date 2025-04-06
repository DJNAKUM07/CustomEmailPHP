<?php
include 'auth.php';
include 'db_connection.php';

$fromDate = $_POST['from_date'] ?? $_GET['from_date'] ?? '';
$toDate = $_POST['to_date'] ?? $_GET['to_date'] ?? '';
$logs = [];
$message = '';
$messageType = 'info';
$perPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $perPage;

try {
    $sql = "SELECT * FROM email_logs";
    $countSql = "SELECT COUNT(*) FROM email_logs";
    $conditions = [];

    if (!empty($fromDate) && !empty($toDate)) {
        $conditions[] = "DATE(sent_at) BETWEEN :fromDate AND :toDate";
    } elseif (!empty($fromDate) || !empty($toDate)) {
        $message = "Please select both From Date and To Date.";
        $messageType = 'warning';
    }

    if ($conditions) {
        $whereClause = " WHERE " . implode(" AND ", $conditions);
        $sql .= $whereClause;
        $countSql .= $whereClause;
    }

    $sql .= " ORDER BY sent_at DESC LIMIT :limit OFFSET :offset";

    $stmt = $pdo->prepare($sql);
    if (!empty($fromDate) && !empty($toDate)) {
        $stmt->bindParam(':fromDate', $fromDate);
        $stmt->bindParam(':toDate', $toDate);
    }
    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmtCount = $pdo->prepare($countSql);
    if (!empty($fromDate) && !empty($toDate)) {
        $stmtCount->bindParam(':fromDate', $fromDate);
        $stmtCount->bindParam(':toDate', $toDate);
    }
    $stmtCount->execute();
    $totalLogs = $stmtCount->fetchColumn();
    $totalPages = ceil($totalLogs / $perPage);

    if (empty($logs)) {
        $message = "No email logs found for the selected date range.";
        $messageType = 'secondary';
    }
} catch (PDOException $e) {
    $message = "Error fetching email logs: " . $e->getMessage();
    $messageType = 'danger';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Log List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .modal-body { white-space: pre-wrap; }
        .table th, .table td { vertical-align: middle; }
        .pagination { justify-content: center; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">Email System</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Template</a></li>
                <li class="nav-item"><a class="nav-link" href="list_credentials.php">Credentials</a></li>
                <li class="nav-item"><a class="nav-link" href="send_email.php">Send Email</a></li>
                <li class="nav-item active"><a class="nav-link" href="email_log_list.php">Email Log</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Email Log List</h3>
        <a href="send_email.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Send Email</a>
    </div>

    <?php if ($message): ?>
        <div class="alert alert-<?php echo $messageType; ?> alert-dismissible fade show" role="alert">
            <strong><?php echo ucfirst($messageType); ?>!</strong> <?php echo htmlspecialchars($message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Filter Form -->
    <form method="post" class="card p-3 mb-4 shadow-sm">
        <div class="row g-3">
            <div class="col-md-4">
                <label for="from_date">From Date:</label>
                <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo htmlspecialchars($fromDate); ?>">
            </div>
            <div class="col-md-4">
                <label for="to_date">To Date:</label>
                <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo htmlspecialchars($toDate); ?>">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter Logs</button>
            </div>
        </div>
    </form>

    <?php if (!empty($logs)): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Recipient</th>
                        <th>Subject</th>
                        <th>Sent At</th>
                        <th class="text-center">View</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($log['recipient_email']); ?></td>
                            <td><?php echo htmlspecialchars($log['subject']); ?></td>
                            <td><?php echo htmlspecialchars($log['sent_at']); ?></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-info view-email-btn" 
                                        data-id="<?php echo $log['id']; ?>" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#viewEmailModal">
                                    <i class="fas fa-eye"></i> View
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <?php
                    $queryParams = ['from_date' => $fromDate, 'to_date' => $toDate];
                ?>
                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?<?php echo http_build_query(array_merge($queryParams, ['page' => $page - 1])); ?>">
                        &laquo; Prev
                    </a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="?<?php echo http_build_query(array_merge($queryParams, ['page' => $i])); ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
                <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                    <a class="page-link" href="?<?php echo http_build_query(array_merge($queryParams, ['page' => $page + 1])); ?>">
                        Next &raquo;
                    </a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<!-- Single Dynamic Modal -->
<div class="modal fade" id="viewEmailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Email Content</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="emailContent">
                <div class="text-center text-muted">Loading...</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const modalBody = document.getElementById('emailContent');

    document.querySelectorAll('.view-email-btn').forEach(button => {
        button.addEventListener('click', () => {
            const id = button.getAttribute('data-id');
            modalBody.innerHTML = '<div class="text-center text-muted">Loading...</div>';

            fetch(`get_email_content.php?id=${id}`)
                .then(response => response.text())
                .then(html => {
                    modalBody.innerHTML = html;
                })
                .catch(error => {
                    modalBody.innerHTML = '<div class="text-danger">Error loading content.</div>';
                    console.error('Error:', error);
                });
        });
    });
});
</script>
</body>
</html>
