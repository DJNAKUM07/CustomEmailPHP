<!DOCTYPE html>
<html>
<head>
    <title>Save Email Template</title>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
</head>
<body>
    <h2>Save Email Template</h2>
    <form action="save_template_process.php" method="post" enctype="multipart/form-data">
        Template Name: <input type="text" name="template_name" required><br><br>
        Subject: <input type="text" name="subject" required><br><br>
        Body: <textarea name="body" id="editor" rows="5" cols="30" required></textarea><br><br>
        Image: <input type="file" name="image"><br><br>
        <input type="submit" name="submit" value="Save Template">
    </form>

    <script>
        // Initialize CKEditor on the 'body' textarea
        CKEDITOR.replace('editor');
    </script>
</body>
</html>
