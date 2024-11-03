<?php
include 'auth.php';
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $user_id = $_SESSION['user_id'];

    if ($name && $date && $location && $user_id) {
        $stmt = $conn->prepare("INSERT INTO events (name, description, date, location, user_id) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $name, $description, $date, $location, $user_id);
        $stmt->execute();
        header("Location: index.php");
    } else {
        echo "Please fill in all required fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Event</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <h2>New Event</h2>
        <!-- Logout Button -->
        <form action="logout.php" method="post" class="logout-form">
            <button type="submit" class="btn btn-logout">Logout</button>
        </form>
    </div>
    
    <div class="add-event-container">
        
        <form action="add_event.php" method="post">
            <label for="name">Event Name:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>
            
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>
            
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>
            
            <input type="submit" value="Create Event">
        </form>
    </div>
</body>

</html>
