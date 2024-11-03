<?php
include 'auth.php';
include 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Get the logged-in user's ID
$user_id = $_SESSION['user_id'];

// Pagination and Search Logic
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$searchQuery = '';
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $searchQuery = "AND (name LIKE '%$search%' OR location LIKE '%$search%')";
}

// Fetch the total number of events for pagination with search
$totalEventsQuery = $conn->query("SELECT COUNT(*) as total FROM events WHERE user_id = $user_id $searchQuery");
$totalEvents = $totalEventsQuery->fetch_assoc()['total'];
$totalPages = ceil($totalEvents / $limit);

// Fetch events for the current page with search
$eventsQuery = "SELECT id, name, date, location FROM events WHERE user_id = $user_id $searchQuery LIMIT $limit OFFSET $offset";
$eventsResult = $conn->query($eventsQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="header">
        <h2>Events</h2>
        <!-- Logout Button -->
        <form action="logout.php" method="post" class="logout-form">
            <button type="submit" class="btn btn-logout">Logout</button>
        </form>
    </div>

    <!-- Search Form -->
    <div class="search_form">
        <form method="get" action="index.php">
            <input type="text" name="search" placeholder="Search events by name or location" value="<?php echo isset($search) ? htmlspecialchars($search) : ''; ?>">
            <button type="submit">Search</button>
        </form>

    </div>

    <form action="add_event.php" method="get" style="display: inline;">
        <button type="submit" class="btn">Create New Event</button>
    </form>
    
    <ul>
        <?php while ($event = $eventsResult->fetch_assoc()): ?>
            <li>
                <strong><?php echo htmlspecialchars($event['name']); ?></strong><br>
                Date: <?php echo htmlspecialchars($event['date']); ?><br>
                Location: <?php echo htmlspecialchars($event['location']); ?><br>
                <form action="event_details.php" method="get" style="display: inline;">
                    <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
                    <button type="submit" class="btn">View Details</button>
                </form>
                <form action="delete_event.php" method="get" style="display: inline;">
                    <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
                    <button type="submit" class="btn btn-delete">Delete</button>
                </form>
            </li>
        <?php endwhile; ?>
    </ul>

    <!-- Pagination Links -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="index.php?page=<?php echo $i; ?>&search=<?php echo isset($search) ? htmlspecialchars($search) : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </div>
</body>
</html>
