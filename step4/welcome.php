<?php
require 'format.inc.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Stalking the Wumpus</title>
    <link href="styles.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <?php echo present_header("Stalking the Wumpus"); ?>

    <div id="game-body">
        <img src="cave-wumpus.jpg" width="600" height="325" alt="Wumpus image" id="cave">
        <p>Welcome to <span id="welcome-wumpus">Stalking the Wumpus</span></p>
        <p><a href="instructions.php">Instructions</a> </p>
        <p><a href="game.php">Start Game</a> </p>
    </div>
</body>
</html>