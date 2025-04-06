<?php
session_start();
$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Save Email Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 4 -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Summernote CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">

    <style>
        body { background-color: #f8f9fa; }
        .card { margin-top: 2rem; }
        .alert { margin-top: 1rem; }
        .form-group label { font-weight: 500; }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">Email System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Template</a></li>
                    <li class="nav-item"><a class="nav-link" href="list_credentials.php">Credentials</a></li>
                    <li class="nav-item"><a class="nav-link" href="send_email.php">Send Email</a></li>
                    <li class="nav-item"><a class="nav-link" href="email_log_list.php">Email Log</a></li>
                </ul>
            </div>
        </div>
    </nav>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Save Email Template</h2>
        <a href="index.php" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left me-1"></i> Back
        </a>
    </div>

    <?php if ($success): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success:</strong> <?= htmlspecialchars($success) ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span>&times;</span></button>
        </div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error:</strong> <?= htmlspecialchars($error) ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span>&times;</span></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form id="templateForm" action="save_template_process.php" method="post" enctype="multipart/form-data" novalidate>
                <div class="form-group">
                    <label for="template_name">Template Name</label>
                    <input type="text" name="template_name" id="template_name" class="form-control" required>
                    <div class="invalid-feedback">Template name is required.</div>
                </div>

                <div class="form-group mt-3">
                    <label for="subject">Subject</label>
                    <input type="text" name="subject" id="subject" class="form-control" required>
                    <div class="invalid-feedback">Subject is required.</div>
                </div>

                <div class="form-group mt-3">
                    <label for="body">Body</label>
                    <textarea name="body" id="summernote" class="form-control" required></textarea>
                    <div class="invalid-feedback" id="bodyError" style="display:none;">Body is required.</div>
                </div>

                <div class="form-group mt-3">
                    <label for="image">Attachment (optional)</label>
                    <input type="file" name="image" id="image" class="form-control-file">
                </div>

                <button type="submit" name="submit" class="btn btn-primary mt-4">
                    <i class="fas fa-save me-1"></i> Save Template
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>

<script>
    $(document).ready(function () {
        $('#summernote').summernote({
            height: 300,
            placeholder: 'Write your email body here...',
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview']]
            ]
        });

        // Bootstrap validation + summernote body check
        $('#templateForm').on('submit', function (e) {
            let form = this;
            let isValid = form.checkValidity();

            const bodyContent = $('#summernote').summernote('isEmpty') ? '' : $('#summernote').val();
            if (!bodyContent || bodyContent.trim() === '') {
                $('#bodyError').show();
                isValid = false;
            } else {
                $('#bodyError').hide();
            }

            if (!isValid) {
                e.preventDefault();
                e.stopPropagation();
                $(form).addClass('was-validated');
            }
        });
    });
</script>

</body>
</html>
