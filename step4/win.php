<?php
require 'format.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>You Killed the Wumpus</title>
    <link href="styles.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <?php echo present_header("Stalking the Wumpus"); ?>

    <div id="game-body">
        <img src="dead-wumpus.jpg" width="600" height="325" alt="Dead wumpus" id="cave">
        <p>You killed the Wumpus</p>
        <p><a href="welcome.php">New Game</a> </p>
    </div>
</body>
</html>