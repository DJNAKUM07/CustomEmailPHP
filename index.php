<?php
include 'auth.php'; // Include the isLoggedIn() function
// session_start();
// if (!isset($_SESSION['user_id'])) {
//     // Redirect to the login page
//     header("Location: login.php");
//     exit(); // Stop further execution
// }
?>


<!DOCTYPE html>
<html>
<head>
    <title>Email Templates</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-5">

                <h2>Email Templates</h2>
            </div>
            <div class="col-md-7">
                <a href="save_template.php" class="btn btn-primary">Add New Template</a>
                <a href="send_email.php" class="btn btn-primary">Send Email</a>
            <a href="email_log_list.php" class="btn btn-primary">Email Log</a>
            <a href="list_credentials.php" class="btn btn-primary">Credential List</a>
            <a href="logout.php" class="btn btn-primary">Log Out</a>

            </div>

        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Template Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    // Connect to your database (assuming using PDO)
                    include 'db_connection.php';
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Fetch templates from database
                    $stmt = $pdo->query("SELECT id, template_name FROM email_templates");
                    while ($template = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>';
                        echo '<td>' . $template['template_name'] . '</td>';
                        echo '<td>';
                        echo '<button class="btn btn-info view-template" data-id="' . $template['id'] . '">View</button> ';
                        echo '<button class="btn btn-warning edit-template" data-id="' . $template['id'] . '">Edit</button>';
                        echo '  <button class="btn btn-danger delete-template" data-id="' . $template['id'] . '">Delete</button>';
                        echo '</td>';
                        echo '</tr>';
                    }
                } catch (PDOException $e) {
                    die("Error: " . $e->getMessage());
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- View Template Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewModalLabel">View Template</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 id="viewTemplateName"></h5>
                    <h6 id="viewTemplateSubject"></h6>
                    <div id="viewTemplateBody"></div>
                    <img id="viewTemplateImage" src="" alt="Template Image" class="img-fluid mt-3">
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Template Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Template</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editTemplateForm" action="edit_template_process.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="template_id" id="editTemplateId">
                        <div class="form-group">
                            <label for="editTemplateName">Template Name:</label>
                            <input type="text" name="template_name" id="editTemplateName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editTemplateSubject">Subject:</label>
                            <input type="text" name="subject" id="editTemplateSubject" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="editTemplateBody">Body:</label>
                            <textarea name="body" id="editTemplateBody" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="editTemplateImage">Image:</label>
                            <input type="file" name="image" id="editTemplateImage" class="form-control-file">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
       $(document).ready(function() {
    // Delete template via AJAX
    $('.delete-template').on('click', function() {
        const templateId = $(this).data('id');
        if (confirm("Are you sure you want to delete this template?")) {
            $.ajax({
                url: 'delete_template.php',
                type: 'POST',
                data: { id: templateId },
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
        // Initialize CKEditor on the 'editTemplateBody' textarea
        CKEDITOR.replace('editTemplateBody');

        $(document).ready(function() {
            $('.view-template').on('click', function() {
                const templateId = $(this).data('id');
                // Fetch template details via AJAX
                $.ajax({
                    url: 'fetch_template.php',
                    type: 'POST',
                    data: { id: templateId },
                    success: function(response) {
                        const template = JSON.parse(response);
                        $('#viewTemplateName').text(template.template_name);
                        $('#viewTemplateSubject').text(template.subject);
                        $('#viewTemplateBody').html(template.body);
                        $('#viewTemplateImage').attr('src', template.image_path);
                        $('#viewModal').modal('show');
                    }
                });
            });

            $('.edit-template').on('click', function() {
                const templateId = $(this).data('id');
                // Fetch template details via AJAX
                $.ajax({
                    url: 'fetch_template.php',
                    type: 'POST',
                    data: { id: templateId },
                    success: function(response) {
                        const template = JSON.parse(response);
                        $('#editTemplateId').val(template.id);
                        $('#editTemplateName').val(template.template_name);
                        $('#editTemplateSubject').val(template.subject);
                        CKEDITOR.instances['editTemplateBody'].setData(template.body);
                        $('#editModal').modal('show');
                    }
                });
            });
        });
    </script>
</body>
</html>
