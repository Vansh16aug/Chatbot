<?php
date_default_timezone_set('Asia/Dhaka');
require_once 'dbconfig/config.php';

// Retrieve and sanitize the user input
$stmt = $db->quote($_POST['txt']);

// Prepare and execute the SELECT query
$sql = "SELECT reply FROM chatbot_hints WHERE question LIKE $stmt";
$result = $db->prepare($sql);
$result->execute();

if ($result->rowCount() > 0) {
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $content = $row['reply'];
} else {
    $content = "Sorry, not able to understand you";
}
$result->closeCursor();

// Add the user message to the 'message' table
$added_on = date('Y-m-d H:i:s');
$insert_user_msg = $db->prepare("INSERT INTO message (message, added_on, type) VALUES (:message, :added_on, :type)");
$insert_user_msg->execute([
    ':message' => $_POST['txt'],
    ':added_on' => $added_on,
    ':type' => 'user',
]);

// Add the bot's reply to the 'message' table
$insert_bot_reply = $db->prepare("INSERT INTO message (message, added_on, type) VALUES (:message, :added_on, :type)");
$insert_bot_reply->execute([
    ':message' => $content,
    ':added_on' => $added_on,
    ':type' => 'bot',
]);

echo $content;
?>
