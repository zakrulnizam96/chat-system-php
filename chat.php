<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

include 'db.php';

// Fetch username
$user_id = $_SESSION['user_id'];
$userResult = $conn->query("SELECT username FROM users WHERE id = $user_id");
$user = $userResult->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Room</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .chat-box {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.2);
        }
        .message-box {
            margin-top: 20px;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 5px;
        }
        .user-message {
            background-color: #007bff;
            color: white;
        }
        .other-message {
            background-color: #6c757d;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="chat-box">
            <h4 class="text-center">Chat Room</h4>
            <div id="chat-container" style="height: 400px; overflow-y: scroll;">
                <!-- Chat messages will be loaded here -->
            </div>
            <form id="chat-form">
                <div class="input-group mt-3">
                    <input type="text" id="message-input" class="form-control" placeholder="Type your message..." required>
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function () {
            // Load chat messages every 2 seconds
            setInterval(loadMessages, 2000);

            function loadMessages() {
                $.get('load_messages.php', function (data) {
                    $('#chat-container').html(data);
                    $('#chat-container').scrollTop($('#chat-container')[0].scrollHeight);
                });
            }

            // Send message
            $('#chat-form').on('submit', function (e) {
                e.preventDefault();
                const message = $('#message-input').val();
                $('#message-input').val('');

                $.post('save_message.php', { message: message }, function () {
                    loadMessages(); // Reload messages after sending
                });
            });
        });
    </script>
</body>
</html>
