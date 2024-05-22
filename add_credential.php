<?php
include 'auth.php'; // Include the isLoggedIn() function
?>


<!DOCTYPE html>
<html>

<head>
    <title>Add Email Credential</title>

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
                <h2>Add Email Credential</h2>
            </div>
            <div class="col-md-2">
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