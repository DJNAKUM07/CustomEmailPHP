<?php
include 'auth.php'; // Include the isLoggedIn() function
include 'db_connection.php'; // Include the database connection

// Initialize variables for date filters
$fromDate = isset($_POST['from_date']) ? $_POST['from_date'] : null;
$toDate = isset($_POST['to_date']) ? $_POST['to_date'] : null;

try {
    // Fetch email logs from the database based on date filters
    $sql = "SELECT * FROM email_logs";
    if ($fromDate && $toDate) {
        $sql .= " WHERE sent_at BETWEEN '$fromDate' AND '$toDate'";
    }
    $sql .= " ORDER BY sent_at DESC";
    $stmt = $pdo->query($sql);
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching email logs: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Email Log List</title>
    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="bootstrap.min.css">
    
    <style>
        .modal-body {
            white-space: pre-wrap; /* Ensure that line breaks in the email body are preserved */
        }
    </style>
</head>
<body>
        <nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Template</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="list_credentials.php">Credentials</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="send_email.php">Send Email</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="email_log_list.php">Email Log
                                <span class="visually-hidden">(current)</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    <div class="m-5">
        <div class="row">
            <div class="col-md-10">
                <h2>Email Log List</h2>
            </div>
            <div class="col-md-2">
                <a href="send_email.php" class="btn btn-primary">Back to Send Email</a>
            </div>
        </div>

        <!-- Form for date filters -->
        <form method="post" class="mb-3">
            <div class="form-row">
                <div class="col">
                    <label for="from_date">From Date:</label>
                    <input type="date" name="from_date" id="from_date" class="form-control" value="<?php echo $fromDate; ?>">
                </div>
                <div class="col">
                    <label for="to_date">To Date:</label>
                    <input type="date" name="to_date" id="to_date" class="form-control" value="<?php echo $toDate; ?>">
                </div>
                <div class="col mt-auto">
                    <button type="submit" class="btn btn-primary mt-4">Search</button>
                </div>
            </div>
        </form>

        <!-- Display email logs in a table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Recipient Email</th>
                    <th>Subject</th>
                    <th>Sent At</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($log['recipient_email']); ?></td>
                        <td><?php echo htmlspecialchars($log['subject']); ?></td>
                        <td><?php echo htmlspecialchars($log['sent_at']); ?></td>
                        <td class="text-center"><button class="btn btn-info" data-toggle="modal" data-target="#viewEmailModal<?php echo $log['id']; ?>"><i class="bi bi-file-earmark-fill"></i></button></td>
                    </tr>

                    <!-- Modal to view email body -->
                    <div class="modal fade" id="viewEmailModal<?php echo $log['id']; ?>" tabindex="-1" aria-labelledby="viewEmailModalLabel<?php echo $log['id']; ?>" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewEmailModalLabel<?php echo $log['id']; ?>">Email Body</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" data-html="true">
    <?php echo trim(htmlspecialchars_decode($log['body'])); ?>
</div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
