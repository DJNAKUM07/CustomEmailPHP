<?php
include 'auth.php'; // Include the isLoggedIn() function
?>


<!DOCTYPE html>
<html>
<head>
    <title>Email Credentials List</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap.min.css">
     <!-- Option 1: Include in HTML -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
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
                            <a class="nav-link " href="index.php">Template
                                
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
            <h2>Email Credentials</h2>
            </div>
            <div class="col-md-2">
            <a href="add_credential.php" class="btn btn-success">Add New Credential</a>
            </div>
        </div>
       
        <table class="table table-bordered">
            <thead>
                <tr>
                    <!-- <th>SMTP Host</th>
                    <th>SMTP Port</th> -->
                    <th>Username</th>
                    <th>Password</th>
                    <th>Sender Name</th>
                    <th>Sender Email</th>
                    <th class="text-center">Actions</th> <!-- New column for action buttons -->
                </tr>
            </thead>
            <tbody>
                <?php
                include 'read_credentials.php';
                foreach ($credentials as $credential) {
                    echo '<tr>';
                    // echo '<td>' . $credential['smtp_host'] . '</td>';
                    // echo '<td>' . $credential['smtp_port'] . '</td>';
                    echo '<td>' . $credential['username'] . '</td>';
                    echo '<td>' . $credential['password'] . '</td>';
                    echo '<td>' . $credential['sender_name'] . '</td>';
                    echo '<td>' . $credential['sender_email'] . '</td>';
                    echo '<td class="text-center"> <button type="button" class="btn btn-secondary " data-toggle="modal" data-target="#viewModal' . $credential['id'] . '"><i class="bi bi-file-earmark-fill"></i></button>';
                    // Edit button linking to edit_credential.php with ID parameter
                    echo '  <a href="edit_credential.php?id=' . $credential['id'] . '" class="btn btn-primary "><i class="bi bi-pencil-square"></i></a>';
                    // Delete button linking to delete_credential.php with ID parameter
                    echo '  <button class="btn btn-danger  delete_credential" data-id="' . $credential['id'] . '"><i class="bi bi-trash"></i></button>';
                    // View button to open modal
                    
                    echo '</td>';
                    echo '</tr>';
                    
                    // Modal for each credential
                    echo '<div class="modal fade" id="viewModal' . $credential['id'] . '" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">';
                    echo '<div class="modal-dialog" role="document">';
                    echo '<div class="modal-content">';
                    echo '<div class="modal-header">';
                    echo '<h5 class="modal-title" id="viewModalLabel">View Credential</h5>';
                    echo '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo '</div>';
                    echo '<div class="modal-body">';
                    // Display credential details inside the modal
                    echo '<p>SMTP Host: ' . $credential['smtp_host'] . '</p>';
                    echo '<p>SMTP Port: ' . $credential['smtp_port'] . '</p>';
                    echo '<p>Username: ' . $credential['username'] . '</p>';
                    echo '<p>Password: ' . $credential['password'] . '</p>';
                    echo '<p>Sender Name: ' . $credential['sender_name'] . '</p>';
                    echo '<p>Sender Email: ' . $credential['sender_email'] . '</p>';
                    echo '</div>';
                    echo '<div class="modal-footer">';
                    echo '<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS (needs to be placed at the end of the body for faster loading) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

$(document).ready(function() {
    // Delete template via AJAX
    $('.delete_credential').on('click', function() {
        const id = $(this).data('id');
        if (confirm("Are you sure you want to delete this credential?")) {
            $.ajax({
                url: 'delete_credential.php',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    // Reload the page after successful deletion
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    });
});
</script>