<?php
require 'format.inc.php';
require 'wumpus.inc.php';
$room = 1; // current room we are in
$birds = 7; // room that the birds are in
$pits = array(3, 10, 13); // Rooms with a bottomless pit
$wumpus = 16; // room with the wumpus

$cave = cave_array();
if( isset($_GET['r']) && isset($cave[$_GET['r']]) ){
    //we have passed a room number
    $room = $_GET['r'];
}
if( $room == $birds ){ $room = 10; }

//check if in room with bottomless pit or with wumpus
if( in_array($room, $pits) || $room==$wumpus ){
    header("Location: lose.php");
    exit;
}

// arrow functionality
if( isset($_GET['a']) ){
    if( is_int((int)$_GET['a']) ){
        if( $_GET['a']>0 && $_GET['a']<=$cave[count($cave)] ){
            if( in_array($_GET['a'], $cave[$room]) ){
                $arrowRoom = $_GET['a'];
                if( $arrowRoom == $wumpus ){
                    header("Location: win.php");
                    exit;
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Stalking the Wumpus</title>
    <link href="styles.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <?php echo present_header("Stalking the Wumpus"); ?>

    <div id="game-body">
        <img src="cave.jpg" width="600" height="325" alt="Cave image" id="cave">
        <?php
//        echo "<pre>";
//        print_r(cave_array());
//        echo "</pre>";
//        echo '<p>' . date("g:ia l, F j, Y") . '</p>';
        ?>
        <p>You are in room <?php echo $room;?></p>
        <div id="game-info">
            <?php
                $heard = 0;
                for( $i=0; $i<count($cave[$room]); $i++ ){
                    if( $cave[$room][$i] == $birds ){
                        echo "<p>You hear birds!</p>";
                        $heard = 1;
                    }
                }
                if( !$heard ){ echo "<p>&nbsp;</p>"; }

                $nippy = 0;
                for( $i=0; $i<count($pits); $i++ ){
                    if( in_array($room, $cave[$pits[$i]]) ){
                        echo "<p>You feel a draft!</p>";
                        $nippy = 1;
                    }
                }
                if( !$nippy ){ echo "<p>&nbsp;</p>"; }

                $smelly = 0;
                for( $i=0; $i<count($cave[$room]); $i++ ){
                    if( $cave[$room][$i] == $wumpus ){
                        echo "<p>You smell a wumpus!</p>";
                        $smelly = 1;
                        break;
                    }
                    for( $j=0; $j<count($cave[$cave[$room][$i]]); $j++ ){
                        //echo $cave[$cave[$room][$i]][$j];
                        if( $cave[$cave[$room][$i]][$j] == $wumpus ){
                            echo "<p>You smell a wumpus!</p>";
                            $smelly = 1;
                            break;
                        }
                    }
                }
                if( !$smelly ){ echo "<p>&nbsp;</p>"; }
            ?>
        </div>

        <div class="rooms">
            <div class="room"><img src="cave2.jpg" width="180" height="135" alt="Cave 2 image"></div>
            <div class="room"><img src="cave2.jpg" width="180" height="135" alt="Cave 2 image"></div>
            <div class="room"><img src="cave2.jpg" width="180" height="135" alt="Cave 2 image"></div>
        </div>
        <div class="labels">
            <div class="label"><a href="game.php?r=<?php echo $cave[$room][0] ?>"><?php echo $cave[$room][0]; ?></a></div>
            <div class="label"><a href="game.php?r=<?php echo $cave[$room][1] ?>"><?php echo $cave[$room][1]; ?></a></div>
            <div class="label"><a href="game.php?r=<?php echo $cave[$room][2] ?>"><?php echo $cave[$room][2]; ?></a></div>
        </div>
        <div class="labels">
            <div class="label"><a href="game.php?r=<?php echo $room ?>&a=<?php echo $cave[$room][0]; ?>">Shoot Arrow</a></div>
            <div class="label"><a href="game.php?r=<?php echo $room ?>&a=<?php echo $cave[$room][1]; ?>">Shoot Arrow</a></div>
            <div class="label"><a href="game.php?r=<?php echo $room ?>&a=<?php echo $cave[$room][2]; ?>">Shoot Arrow</a></div>
        </div>

        <p id="game-body-bottom">You have 3 arrows remaining.</p>
    </div>
</body>
</html>