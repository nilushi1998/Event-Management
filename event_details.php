<?php
include 'auth.php';
include 'db_connection.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT name, description, date, location FROM events WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$event = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="header">
        <h2>Event Details</h2>
        <!-- Logout Button -->
        <form action="logout.php" method="post" class="logout-form">
            <button type="submit" class="btn btn-logout">Logout</button>
        </form>
    </div>

    <div class="container">
        
        <div class="event-details">
        <h2><?php echo htmlspecialchars($event['name']); ?></h2>
            <p><strong>Date:</strong> <?php echo htmlspecialchars($event['date']); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($event['description']); ?></p>
        </div>
        
        <!-- Back to Event List button -->
        <button class="btn-back" onclick="window.location.href='index.php'">Back to Event List</button>
    </div>
</body>
</html>


