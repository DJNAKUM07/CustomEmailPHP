<?php
include 'auth.php'; // Include the isLoggedIn() function
?>

<!DOCTYPE html>
<html>
<head>
    <title>Save Email Template</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap.min.css">
    <!-- SummerNote CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
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
                            <a class="nav-link active" href="index.php">Template
                                <span class="visually-hidden">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="list_credentials.php">Credentials</a>
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
                <h2>Save Email Template</h2>
            </div>
            <div class="col-md-2">
            <a href="index.php" class="btn btn-primary">Back to Template List</a>
            </div>
        </div>
        
        <form action="save_template_process.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="template_name">Template Name:</label>
                <input type="text" name="template_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input type="text" name="subject" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="editor">Body:</label>
                <textarea name="body" id="summernote" class="form-control" rows="5" required></textarea>
            </div>
            <br/>
            <div class="form-group">
                <label for="image">Attachment:</label>
                <input type="file" name="image" class="form-control-file">
            </div>
            <br/>
            <button type="submit" name="submit" class="btn btn-primary">Save Template</button>
        </form>
    </div>

    <!-- jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- SummerNote JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: true // set focus to editable area after initializing summernote
            });
        });
    </script>
</body>
</html>
