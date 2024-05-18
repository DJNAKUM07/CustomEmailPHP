<?php
include 'auth.php'; // Include the isLoggedIn() function
?>


<!DOCTYPE html>
<html>
<head>
    <title>Email Credentials List</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
    <div class="row">
            <div class="col-md-8">
            <h2>Email Credentials List</h2>
            </div>
            <div class="col-md-4">
            <a href="index.php" class="btn btn-primary">Template List</a>
            <a href="add_credential.php" class="btn btn-primary">Add Credentials</a>
            </div>
        </div>
       
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SMTP Host</th>
                    <th>SMTP Port</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Sender Name</th>
                    <th>Sender Email</th>
                    <th>Actions</th> <!-- New column for action buttons -->
                </tr>
            </thead>
            <tbody>
                <?php
                include 'read_credentials.php';
                foreach ($credentials as $credential) {
                    echo '<tr>';
                    echo '<td>' . $credential['smtp_host'] . '</td>';
                    echo '<td>' . $credential['smtp_port'] . '</td>';
                    echo '<td>' . $credential['username'] . '</td>';
                    echo '<td>' . $credential['password'] . '</td>';
                    echo '<td>' . $credential['sender_name'] . '</td>';
                    echo '<td>' . $credential['sender_email'] . '</td>';
                    // Edit button linking to edit_credential.php with ID parameter
                    echo '<td><a href="edit_credential.php?id=' . $credential['id'] . '" class="btn btn-primary btn-sm">Edit</a>';
                    // Delete button linking to delete_credential.php with ID parameter
                    echo '  <button class="btn btn-danger btn-sm delete_credential" data-id="' . $credential['id'] . '">Delete</button>';
                    // View button to open modal
                    echo ' <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#viewModal' . $credential['id'] . '">View</button>';
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