<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user from the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        header("Location: index.php");
        exit();
    } else {
        echo "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>
        <form method="post" action="login.php">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
            <div class="link">
                <span>Don't have an account?</span> <a href="signup.php"> Signup</a>
            </div>
        </form>
    </div>
</body>
</html>

