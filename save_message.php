<?php
session_start();
include 'db.php';

if (isset($_POST['message']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO messages (user_id, message) VALUES ('$user_id', '$message')";
    $conn->query($sql);
}

$conn->close();
?>
