<?php
require 'auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Send Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .spinner-border {
    display: none; 
    position: fixed; 
    top: 50%; 
    left: 50%; 
    transform: translate(-50%, -50%); 
    z-index: 1055; 
    width: 4rem; 
    height: 4rem; 
    border-width: 0.4em; 
    animation: spin 1s linear infinite; 
}

/* Smooth spinning animation */
@keyframes spin {
    from { transform: translate(-50%, -50%) rotate(0deg); }
    to { transform: translate(-50%, -50%) rotate(360deg); }
}
.toast-container {
    position: fixed;
    top: 1rem; /* Adjust top margin */
    left: 50%;
    transform: translateX(-50%); /* Center horizontally */
    z-index: 1060;
    width: 300px; /* Set a fixed width for consistent layout */
    text-align: center;
}

    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">📧 Email System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Templates</a></li>
                <li class="nav-item"><a class="nav-link" href="list_credentials.php">Credentials</a></li>
                <li class="nav-item"><a class="nav-link active" href="send_email.php">Send Email</a></li>
                <li class="nav-item"><a class="nav-link" href="email_log_list.php">Email Log</a></li>
                <li class="nav-item"><a class="nav-link text-light font-weight-bold" href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Send Email</h3>
        <a href="save_template.php" class="btn btn-success">+ Add New Template</a>
    </div>

    <form id="emailForm" method="POST">
        <div class="form-group">
            <label for="template">Choose Template</label>
            <select name="template" class="form-control" required>
                <option value="">Select Template</option>
                <?php
                include 'db_connection.php';
                $stmt = $pdo->query("SELECT id, template_name FROM email_templates");
                while ($template = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $template['id'] . '">' . htmlspecialchars($template['template_name']) . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="credential">Choose Email Credentials</label>
            <select name="credential" class="form-control" required>
                <option value="">Select Email Credentials</option>
                <?php
                $stmt = $pdo->query("SELECT id, sender_name FROM credentials");
                while ($credential = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $credential['id'] . '">' . htmlspecialchars($credential['sender_name']) . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="recipient_email">Recipient Email</label>
            <input type="email" name="recipient_email" class="form-control" placeholder="example@example.com" required>
        </div>

        <button type="submit" class="btn btn-primary">Send Email</button>
    </form>
</div>

<!-- Spinner -->
<div class="spinner-border text-primary" role="status">
    <span class="sr-only">Sending...</span>
</div>

<!-- Toast Container -->
<div class="toast-container"></div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function () {
        // Hide spinner initially
        $('.spinner-border').hide();

        $('#emailForm').on('submit', function (e) {
            e.preventDefault();
            $('.spinner-border').show(); // Show spinner when form is submitted

            $.ajax({
                url: 'send_email_process.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    $('.spinner-border').hide(); // Hide spinner on success
                    $('.toast-container').html(response);
                    $('.toast').toast('show');
                },
                error: function () {
                    $('.spinner-border').hide(); // Hide spinner on error
                    $('.toast-container').html(`
                        <div class="toast bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
                            <div class="toast-header">
                                <strong class="mr-auto">Error</strong>
                                <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast">&times;</button>
                            </div>
                            <div class="toast-body">An unexpected error occurred.</div>
                        </div>
                    `);
                    $('.toast').toast('show');
                }
            });
        });
    });
</script>

</body>
</html>
