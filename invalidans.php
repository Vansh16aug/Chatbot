<?php
require_once 'dbconfig/config.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Report Invalid Response</title>
    <style>
        input {
            font-size: 1vw;
        }
        table {
            color: white;
            border-radius: 19px;
            background: linear-gradient(blue, black, blue);
        }
        #button {
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            height: 32px;
            width: 145px;
            border-radius: 25px;
            font-size: 16px;
        }
        body {
            background: linear-gradient(black, black);
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }
    </style>
</head>
<body>
    <form action="" method="POST">
        <table border="0" bgcolor="black" align="center" cellspacing="50">
            <div id="main-wrapper">
                <center>
                    <div class="imgcontainer">
                        <img src="image/bot_avatar.png" class="avatar" />
                    </div>
                </center>
            </div>
            <tr>
                <td>User Query</td>
                <td><input type="text" name="user_message" placeholder="Enter user query" required></td>
            </tr>
            <tr>
                <td>Bot Reply</td>
                <td><input type="text" name="bot_response" placeholder="Enter bot response" required></td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" id="button" name="submit" value="Report as Invalid" />
                </td>
            </tr>
        </table>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $userMessage = $_POST['user_message'];
        $botResponse = $_POST['bot_response'];

        if (!empty($userMessage) && !empty($botResponse)) {
            try {
                $sql = "INSERT INTO invalid (user_message, bot_response) VALUES (:user_message, :bot_response)";
                $stmt = $db->prepare($sql);

                // Bind parameters to prevent SQL injection
                $stmt->bindParam(':user_message', $userMessage);
                $stmt->bindParam(':bot_response', $botResponse);

                if ($stmt->execute()) {
                    echo '<script type="text/javascript"> alert("Invalid response reported successfully!") </script>';
                } else {
                    echo '<script type="text/javascript"> alert("Error reporting invalid response.") </script>';
                }
                $stmt->closeCursor();
            } catch (PDOException $e) {
                echo '<script type="text/javascript"> alert("Database error: ' . $e->getMessage() . '") </script>';
            }
        } else {
            echo '<script type="text/javascript"> alert("Both fields are required!") </script>';
        }
    }
    ?>
</body>
</html>
