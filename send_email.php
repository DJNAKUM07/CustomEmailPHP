<?php
include 'auth.php'; // Include the isLoggedIn() function
?>

<!DOCTYPE html>
<html>

<head>
    <title>Send Email</title>
    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="h ttps://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->

    <link rel="stylesheet" href="bootstrap.min.css">

    <style>
        .spinner-border {
            position: fixed;
            top: 50%;
            left: 50%;
            display: none;
        }

        .spinner-container {
            position: fixed;
            top: 50%;
            left: 50%;
            /* transform: translate(-50%, -50%); */
            display: none;
        }
    </style>
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
                        <a class="nav-link" href="index.php">Template</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="list_credentials.php">Credentials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="send_email.php">Send Email
                            <span class="visually-hidden">(current)</span>
                        </a>
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
                <h2>Select Email Template and Enter Recipient</h2>

            </div>
            <!-- Button to redirect to "Add new Template" page -->
            <div class="col-md-2">
                <a href="save_template.php" class="btn btn-success mb-3">Add New Template</a>
            </div>
        </div>
        <form id="emailForm" action="send_email_process.php" method="post">
            <div class="form-group">
                <label for="template">Choose a template:</label>
                <select name="template" class="form-control" required>
                    <option value="">Select Template</option>
                    <?php
                    try {
                        // Connect to your database (assuming using PDO)
                        include 'db_connection.php';
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        // Fetch templates from database
                        $stmt = $pdo->query("SELECT id, template_name FROM email_templates");
                        while ($template = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $template['id'] . '">' . $template['template_name'] . '</option>';
                        }
                    } catch (PDOException $e) {
                        die("Error: " . $e->getMessage());
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="credential">Choose email credentials:</label>
                <select name="credential" class="form-control" required>
                    <option value="">Select Email Credentials</option>
                    <?php
                    try {
                        // Fetch email credentials from the database
                        $stmt = $pdo->query("SELECT id, sender_name FROM credentials");
                        while ($credential = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $credential['id'] . '">' . $credential['sender_name'] . '</option>';
                        }
                    } catch (PDOException $e) {
                        die("Error: " . $e->getMessage());
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="recipient_email">Recipient Email:</label>
                <input type="email" name="recipient_email" class="form-control" required>
            </div>
            <br />
            <button type="submit" name="submit" class="btn btn-info">
                Send Email
            </button>
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>

        </form>
        <br>
        <!-- Toast container -->
        <div class="toast-container">
            <div id="toast-success" class="toast bg-success text-white" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Success</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Email sent successfully!
                </div>
            </div>
            <div id="toast-error" class="toast bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Error</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Error sending email. Please try again.
                </div>
            </div>
        </div>
    </div>



    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('emailForm').addEventListener('submit', function() {
            // Show spinner
            document.querySelector('.spinner-border').style.display = 'inline-block';
        });

        // Display toast if needed
        <?php if (isset($_GET['success']) && $_GET['success'] == 1) : ?>
            var successToast = new bootstrap.Toast(document.getElementById('toast-success'), {
                delay: 3000
            });
            successToast.show();
        <?php elseif (isset($_GET['error']) && $_GET['error'] == 1) : ?>
            var errorToast = new bootstrap.Toast(document.getElementById('toast-error'), {
                delay: 3000
            });
            errorToast.show();
        <?php endif; ?>
    </script>
</body>

</html>