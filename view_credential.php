<!DOCTYPE html>
<html>
<head>
    <title>View Email Credential</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Email Credential Details</h2>
        <?php
        include 'db_connection.php';

        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
            $id = $_GET['id'];

            try {
                $stmt = $pdo->prepare("SELECT * FROM credentials WHERE id = ?");
                $stmt->execute([$id]);
                $credential = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($credential) {
                    echo '<table class="table table-bordered">';
                    echo '<tbody>';
                    echo '<tr><td>ID</td><td>' . $credential['id'] . '</td></tr>';
                    echo '<tr><td>SMTP Host</td><td>' . $credential['smtp_host'] . '</td></tr>';
                    echo '<tr><td>SMTP Port</td><td>' . $credential['smtp_port'] . '</td></tr>';
                    echo '<tr><td>Username</td><td>' . $credential['username'] . '</td></tr>';
                    echo '<tr><td>Password</td><td>' . $credential['password'] . '</td></tr>';
                    echo '<tr><td>Sender Name</td><td>' . $credential['sender_name'] . '</td></tr>';
                    echo '<tr><td>Sender Email</td><td>' . $credential['sender_email'] . '</td></tr>';
                    echo '</tbody>';
                    echo '</table>';
                } else {
                    echo "Credential not found.";
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "Invalid request.";
        }
        ?>
    </div>
</body>
</html>
