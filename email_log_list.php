<?php
include 'auth.php'; // Include the isLoggedIn() function

?>


<?php
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
</head>
<body>
    <div class="container mt-5">
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
                    <button type="submit" class="btn btn-primary mt-4">Filter</button>
                </div>
            </div>
        </form>
        
        <!-- Display email logs in a table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                   
                    <th>Recipient Email</th>
                    <th>Subject</th>
                    <th>Body</th>
                    <th>Sent At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?php echo $log['recipient_email']; ?></td>
                        <td><?php echo $log['subject']; ?></td>
                        <td><?php echo $log['body']; ?></td>
                        <td><?php echo $log['sent_at']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
