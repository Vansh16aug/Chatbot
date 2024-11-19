<!DOCTYPE html>
<html lang="en">
<body>
<head>
	<meta charset="utf-8"> 
	<title>Admin Portal</title>
	<link rel="stylesheet" href="navbar.css">
	<!--<link href="https://fonts.googleapis.com/css?family=Alfa+Slab+One|Open+Sans" rel="stylesheet">-->
</head>
<header>
	<icon>
		
	</icon>
	<h1>BOSS<span><span>BOT</span></span></h1>
	<nav>
		<ul>			
			<li><a href="adminlogin.php">Chats</a></li>
			<li><a href="qna.php">Dataset</a></li>
			<li><a href="invalid.php">Invalid</a></li>
			<li><a href="index.php">Sign Out</a></li>
		</ul>
	</nav>
</header>
<body>
	<table align="center" border="1px" style="width: 800px; line-height: 20px">
    <tr>
        <th colspan="3"><h2>Invalid Responses</h2></th>
    </tr>
    <tr>
        <th align="center">ID</th>
        <th align="center">User Message</th>
        <th align="center">Bot Response</th>
    </tr>
    <?php
    require_once 'dbconfig/config.php';
    try {
        $sql = "SELECT id, user_message, bot_response FROM invalid";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['user_message']}</td>
                        <td>{$row['bot_response']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No invalid responses reported.</td></tr>";
        }
        $stmt->closeCursor();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
</table>


</body>
</html>
</html>
