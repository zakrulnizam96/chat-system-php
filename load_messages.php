<?php
session_start();
include 'db.php';

if (isset($_SESSION['username'])) {
    $sql = "SELECT messages.message, messages.timestamp, users.username FROM messages JOIN users ON messages.user_id = users.id ORDER BY messages.timestamp ASC";
    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $message = $row['message'];
        $timestamp = date('H:i', strtotime($row['timestamp']));

        // Conditionally add classes based on the logged-in user
        $messageClass = ($username === $_SESSION['username']) ? "user-message" : "other-message";

        echo "<div class='message-box $messageClass'>";
        echo "<strong>$username</strong> <small>[$timestamp]</small><br>";
        echo htmlspecialchars($message);
        echo "</div>";
    }
} else {
    echo "Session not set. Please log in.";
}

$conn->close();
?>
