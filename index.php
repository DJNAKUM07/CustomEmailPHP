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
    <title>Email Templates</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Icons -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Summernote -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">

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
                    <li class="nav-item"><a class="nav-link active" href="index.php">Templates</a></li>
                    <li class="nav-item"><a class="nav-link" href="list_credentials.php">Credentials</a></li>
                    <li class="nav-item"><a class="nav-link" href="send_email.php">Send Email</a></li>
                    <li class="nav-item"><a class="nav-link" href="email_log_list.php">Email Log</a></li>
                    <li class="nav-item"><a class="nav-link text-light font-weight-bold" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Email Templates</h3>
            <a href="save_template.php" class="btn btn-success"><i class="bi bi-plus-lg"></i> Add New Template</a>
        </div>

        <!-- Alerts -->
        <?php if ($successMessage): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill mr-1"></i> <?= htmlspecialchars($successMessage) ?>
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        <?php endif; ?>
        <?php if ($errorMessage): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill mr-1"></i> <?= htmlspecialchars($errorMessage) ?>
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        <?php endif; ?>

        <!-- Table -->
        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-striped table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Template Name</th>
                            <th>Subject</th>
                            <th class="text-center" style="width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            include 'db_connection.php';
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stmt = $pdo->query("SELECT id, template_name, subject FROM email_templates");

                            while ($template = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>
                                    <td>" . htmlspecialchars($template['template_name']) . "</td>
                                    <td>" . htmlspecialchars($template['subject']) . "</td>
                                    <td class='text-center'>
                                        <button class='btn btn-sm btn-outline-secondary view-template' data-id='{$template['id']}'><i class='bi bi-eye'></i></button>
                                        <button class='btn btn-sm btn-outline-primary edit-template' data-id='{$template['id']}'><i class='bi bi-pencil'></i></button>
                                        <button class='btn btn-sm btn-outline-danger delete-template' data-id='{$template['id']}'><i class='bi bi-trash'></i></button>
                                    </td>
                                </tr>";
                            }
                        } catch (PDOException $e) {
                            echo "<tr><td colspan='3' class='text-danger text-center'>Error: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- View Modal -->
    <div class="modal fade" id="viewModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">View Template</h5>
                    <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <h5 id="viewTemplateName"></h5>
                    <h6 id="viewTemplateSubject" class="text-muted"></h6>
                    <div id="viewTemplateBody" class="border rounded p-3 bg-light"></div>
                    <img id="viewTemplateImage" class="img-fluid mt-3 d-none rounded" />
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="editTemplateForm" action="edit_template_process.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">Edit Template</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="template_id" id="editTemplateId">

                        <div class="form-group">
                            <label>Template Name</label>
                            <input type="text" name="template_name" id="editTemplateName" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <input type="text" name="subject" id="editTemplateSubject" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Body</label>
                            <textarea name="body" id="editTemplateBody" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control-file">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>

    <script>
        $(function () {
            $('#editTemplateBody').summernote({ height: 250 });

            $('.view-template').click(function () {
                const id = $(this).data('id');
                $.post('fetch_template.php', { id }, function (res) {
                    try {
                        const t = JSON.parse(res);
                        $('#viewTemplateName').text(t.template_name);
                        $('#viewTemplateSubject').text(t.subject);
                        $('#viewTemplateBody').html(t.body);
                        if (t.image_path) {
                            $('#viewTemplateImage').attr('src', t.image_path).removeClass('d-none');
                        } else {
                            $('#viewTemplateImage').addClass('d-none');
                        }
                        $('#viewModal').modal('show');
                    } catch (e) {
                        alert('Failed to load template.');
                    }
                });
            });

            $('.edit-template').click(function () {
                const id = $(this).data('id');
                $.post('fetch_template.php', { id }, function (res) {
                    try {
                        const t = JSON.parse(res);
                        $('#editTemplateId').val(t.id);
                        $('#editTemplateName').val(t.template_name);
                        $('#editTemplateSubject').val(t.subject);
                        $('#editTemplateBody').summernote('code', t.body);
                        $('#editModal').modal('show');
                    } catch (e) {
                        alert('Error loading template for editing.');
                    }
                });
            });

            $('.delete-template').click(function () {
                const id = $(this).data('id');
                if (confirm("Are you sure you want to delete this template?")) {
                    $.post('delete_template.php', { id }, function (res) {
    if (res.trim() === 'success') {
        location.reload();
    } else {
        alert('Failed to delete template.');
    }
});
                }
            });
        });
    </script>
</body>
</html>
