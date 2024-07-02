<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate and sanitize input (you should improve this with proper validation)
    $username = htmlspecialchars($username);
    $password = htmlspecialchars($password);

    // Example: Connect to database and insert user data (you should modify this according to your database setup)
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "StudentFeeManagement_ok";

    // Create connection
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Hash the password using MD5 (for demonstration purposes)
    $hashed_password = md5($password);

    // Prepare SQL statement to insert user data
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        echo '<script>
                alert("Registration successful. You can now login.");
                window.location.href = "login.php";
              </script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body {
            background-color: #0c30c2;
        }

        .square-container {
            max-width: 400px;
            background-color: #0968c8;
        }

        @media (min-width: 768px) {
            .square-container {
                height: 400px;
            }
        }
    </style>
</head>

<body>
<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="square-container rounded p-4">
            <h2 class="text-center text-white mb-4">Register</h2>
            <form action="register.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label text-white">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-white">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Register</button>
                    <a href="login.php" class="btn btn-secondary">Login</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>

</html>
