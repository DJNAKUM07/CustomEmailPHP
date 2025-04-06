<?php
require 'auth.php';
requireLogin();

$successMessage = $_SESSION['success'] ?? '';
$errorMessage = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Email Credentials List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 4.5.2 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn i {
            vertical-align: middle;
        }
        .modal .form-group label {
            font-weight: 600;
        }
        .modal-body {
            max-height: 65vh;
            overflow-y: auto;
        }
    </style>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">📧 Email System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Templates</a></li>
                <li class="nav-item"><a class="nav-link active" href="list_credentials.php">Credentials</a></li>
                <li class="nav-item"><a class="nav-link" href="send_email.php">Send Email</a></li>
                <li class="nav-item"><a class="nav-link" href="email_log_list.php">Email Log</a></li>
                <li class="nav-item"><a class="nav-link text-light font-weight-bold" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Container -->
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Email Credentials</h3>
        <a href="add_credential.php" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i> Add New Credential
        </a>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Username</th>
                        <th>Sender Email</th>
                        <th>Sender Name</th>
                        <th class="text-center" style="width: 180px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    try {
                        include 'read_credentials.php';
                        foreach ($credentials as $credential) {
                            echo "<tr>
                                <td>" . htmlspecialchars($credential['username']) . "</td>
                                <td>" . htmlspecialchars($credential['sender_email']) . "</td>
                                <td>" . htmlspecialchars($credential['sender_name']) . "</td>
                                <td class='text-center'>
                                    <button class='btn btn-sm btn-outline-secondary' data-toggle='modal' data-target='#viewModal{$credential['id']}'><i class='bi bi-eye'></i></button>
                                    <a href='edit_credential.php?id={$credential['id']}' class='btn btn-sm btn-outline-primary'><i class='bi bi-pencil'></i></a>
                                    <button class='btn btn-sm btn-outline-danger delete_credential' data-id='{$credential['id']}'><i class='bi bi-trash'></i></button>
                                </td>
                            </tr>";

                            // Modal for View
                            echo "<div class='modal fade' id='viewModal{$credential['id']}' tabindex='-1' role='dialog' aria-labelledby='modalLabel{$credential['id']}' aria-hidden='true'>
                                <div class='modal-dialog' role='document'>
                                    <div class='modal-content'>
                                        <div class='modal-header'>
                                            <h5 class='modal-title' id='modalLabel{$credential['id']}'>Credential Details</h5>
                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                <span aria-hidden='true'>&times;</span>
                                            </button>
                                        </div>
                                        <div class='modal-body'>
                                            <p><strong>SMTP Host:</strong> " . htmlspecialchars($credential['smtp_host']) . "</p>
                                            <p><strong>SMTP Port:</strong> " . htmlspecialchars($credential['smtp_port']) . "</p>
                                            <p><strong>Username:</strong> " . htmlspecialchars($credential['username']) . "</p>
                                            <p><strong>Password:</strong> " . htmlspecialchars($credential['password']) . "</p>
                                            <p><strong>Sender Name:</strong> " . htmlspecialchars($credential['sender_name']) . "</p>
                                            <p><strong>Sender Email:</strong> " . htmlspecialchars($credential['sender_email']) . "</p>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>";
                        }
                    } catch (PDOException $e) {
                        echo "<tr><td colspan='4' class='text-danger text-center'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
$(document).ready(function () {
    $('.delete_credential').on('click', function () {
        const id = $(this).data('id');
        if (confirm("Are you sure you want to delete this credential?")) {
            $.ajax({
                url: 'delete_credential.php',
                type: 'POST',
                data: { id: id },
                success: function (response) {
                    location.reload();
                },
                error: function () {
                    alert("Failed to delete the credential.");
                }
            });
        }
    });
});
</script>

</body>
</html>
