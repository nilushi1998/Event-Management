<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    // Hash the password
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); 

    // Insert user into the database
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $password);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Signup</h2>
        <form method="post" action="signup.php">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Create Account</button>
            <div class="link">
                <span>Already have an account?</span> <a href="login.php"> Log in</a>
            </div>
        </form>
    </div>
</body>
</html>

