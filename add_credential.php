<?php
include 'auth.php'; // Include the isLoggedIn() function
?>


<!DOCTYPE html>
<html>
<head>
    <title>Add Email Credential</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
    <div class="row">
            <div class="col-md-9">
            <h2>Add Email Credential</h2>
            </div>
            <div class="col-md-3">
            <a href="list_credentials.php" class="btn btn-primary mb-3">Back to Credential List</a>
            </div>
        </div>
        
        <form action="create_credential.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="smtp_host" placeholder="SMTP Host" required>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" name="smtp_port" placeholder="SMTP Port" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="sender_name" placeholder="Sender Name" required>
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="sender_email" placeholder="Sender Email" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Credential</button>
        </form>
    </div>

    <!-- Bootstrap JS (needs to be placed at the end of the body for faster loading) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

