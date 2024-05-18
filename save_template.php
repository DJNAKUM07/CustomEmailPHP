<?php
include 'auth.php'; // Include the isLoggedIn() function
?>


<!DOCTYPE html>
<html>
<head>
    <title>Save Email Template</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
</head>
<body>
    <div class="container mt-5">
    <div class="row">
            <div class="col-md-9">
            <h2>Save Email Template</h2>
            </div>
            <div class="col-md-3">
            <a href="index.php" class="btn btn-primary mb-3">Back to Template List</a>
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
                <textarea name="body" id="editor" class="form-control" rows="5" required></textarea>
            </div>
            <div class="form-group">
                <label for="image">Attachment:</label>
                <input type="file" name="image" class="form-control-file">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Save Template</button>
        </form>
    </div>

    <script>
        // Initialize CKEditor on the 'body' textarea
        CKEDITOR.replace('editor');
    </script>

    <!-- Bootstrap JS and dependencies (Optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
