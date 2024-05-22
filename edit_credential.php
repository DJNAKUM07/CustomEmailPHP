<?php
// Include necessary files and logic to fetch credential data
include 'db_connection.php';

// Check if ID parameter is provided in the URL
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM credentials WHERE id = ?");
        $stmt->execute([$id]);
        $credential = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit(); // Exit script if an error occurs
    }
} else {
    echo "Invalid request.";
    exit(); // Exit script if ID parameter is not provided
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Email Credential</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap.min.css">

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
                            <a class="nav-link" href="index.php">Template
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="list_credentials.php">Credentials
                            <span class="visually-hidden">(current)</span>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="send_email.php">Send Email</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="email_log_list.php">Email Log</a>
                        </li>
                    </ul>

                </div>
            </div>
        </nav>
 
    <div class="m-5">
    <div class="row">
            <div class="col-md-10">
                <h2>Edit Email Credential</h2>
            </div>
            <div class="col-md-2">
                <a href="list_credentials.php" class="btn btn-primary mb-3">Back to Credential List</a>
            </div>
        </div>
        <form action="update_credential.php" method="post">
            <div class="form-group">
                <input type="hidden" name="id" value="<?php echo $credential['id']; ?>">
            </div>
            <div class="form-group">
                <label for="smtp_host">SMTP Host:</label>
                <input type="text" class="form-control" name="smtp_host" value="<?php echo $credential['smtp_host']; ?>" required>
            </div>
            <div class="form-group">
                <label for="smtp_port">SMTP Port:</label>
                <input type="number" class="form-control" name="smtp_port" value="<?php echo $credential['smtp_port']; ?>" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" value="<?php echo $credential['username']; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" value="<?php echo $credential['password']; ?>" required>
            </div>
            <div class="form-group">
                <label for="sender_name">Sender Name:</label>
                <input type="text" class="form-control" name="sender_name" value="<?php echo $credential['sender_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="sender_email">Sender Email:</label>
                <input type="email" class="form-control" name="sender_email" value="<?php echo $credential['sender_email']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Credential</button>
        </form>
    </div>
</body>
</html>
