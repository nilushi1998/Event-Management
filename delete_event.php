<?php
include 'auth.php';
include 'db_connection.php';

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php");
exit;
?>
