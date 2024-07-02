<?php
// includes/auth.php
include 'db.php';

function register($username, $password) {
    global $conn;
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password_hash')";

    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return "Error: " . $sql . "<br>" . $conn->error;
    }
}

function login($username, $password) {
    global $conn;

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        } else {
            return "Invalid password.";
        }
    } else {
        return "No user found with this username.";
    }
}

function logout() {
    session_start();
    session_destroy();
    header("Location: login.php");
    exit();
}

function is_logged_in() {
    session_start();
    return isset($_SESSION['user_id']);
}
?>
