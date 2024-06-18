<?php
    // Start the session
    session_start();

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if the username and password are provided
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            // Mock admin credentials (replace with actual credentials)
            $admin_username = "admin";
            $admin_password = "admin123";

            // Get the username and password from the form
            $username = $_POST["username"];
            $password = $_POST["password"];

            // Check if the provided credentials match the admin credentials
            if ($username == $admin_username && $password == $admin_password) {
                // Admin login successful
                $_SESSION["admin_logged_in"] = true;
                header("Location: admin.php"); // Redirect to admin dashboard
                exit;
            } else {
                // Admin login failed
                $error_message = "Invalid username or password.";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">Admin Login</div>
                    <div class="card-body">
                        <?php if(isset($error_message)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <div class="form-group">
                                <label for="username">Username:</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS (optional) -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
