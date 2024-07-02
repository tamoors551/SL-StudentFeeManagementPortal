<?php
//login.php
// Start session (this should be at the very top of your PHP file)
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have a function to validate user credentials and return user data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Example: Connect to database and validate credentials
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

    // Prepare SQL statement (replace with your actual query)
    $sql = "SELECT id, username FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Login successful
        $row = $result->fetch_assoc();

        // Set session variables
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];

        // Redirect to index.php
        header("Location: ../templates/dashboard.php");
        exit(); // Ensure script stops after redirect
    } else {
        // Login failed
        echo '<script>
                $(document).ready(function() {
                    Swal.fire({
                        icon: "error",
                        title: "Login Failed",
                        text: "Invalid username or password. Please try again."
                    });
                });
              </script>';
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
    <title>Login</title>
    <!-- <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet"> -->

    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <!-- SweetAlert CSS -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css"> -->
    <style>
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

<body class="d-flex justify-content-center align-items-center" style="height: 100vh; background-color: #0c30c2;">
    <div class="square-container d-flex align-items-center justify-content-center rounded p-4">
        <div class="w-100">
            <h2 class="text-center text-white">Login</h2>
            <form action="login.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label text-white">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-white">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="register.php" class="btn btn-secondary">Register</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script scr="../assets/js/jquery-3.6.0.min.js"></script> -->
    <!-- <script scr="../assets/js/jquery-3.6.0.min.js"> </script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <!-- <script scr="../assets/js/popper.min.js"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <!-- <script scr="../assets/js/bootstrap.min.js"></script> -->
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="../assets/js/sweetalert2@10.js"></script> -->
</body>

</html>
