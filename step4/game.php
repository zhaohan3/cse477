<?php
require 'format.inc.php';
require 'lib/game.inc.php';
$view = new Wumpus\WumpusView($wumpus);

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
        <div id="game-info">
            <?php
            echo $view->presentStatus();
            //                $heard = 0;
//                for( $i=0; $i<count($cave[$room]); $i++ ){
//                    if( $cave[$room][$i] == $birds ){
//                        echo "<p>You hear birds!</p>";
//                        $heard = 1;
//                    }
//                }
//                if( !$heard ){ echo "<p>&nbsp;</p>"; }
//
//                $nippy = 0;
//                for( $i=0; $i<count($pits); $i++ ){
//                    if( in_array($room, $cave[$pits[$i]]) ){
//                        echo "<p>You feel a draft!</p>";
//                        $nippy = 1;
//                    }
//                }
//                if( !$nippy ){ echo "<p>&nbsp;</p>"; }
//
//                $smelly = 0;
//                for( $i=0; $i<count($cave[$room]); $i++ ){
//                    if( $cave[$room][$i] == $wumpus ){
//                        echo "<p>You smell a wumpus!</p>";
//                        $smelly = 1;
//                        break;
//                    }
//                    for( $j=0; $j<count($cave[$cave[$room][$i]]); $j++ ){
//                        //echo $cave[$cave[$room][$i]][$j];
//                        if( $cave[$cave[$room][$i]][$j] == $wumpus ){
//                            echo "<p>You smell a wumpus!</p>";
//                            $smelly = 1;
//                            break;
//                        }
//                    }
//                }
//                if( !$smelly ){ echo "<p>&nbsp;</p>"; }
            ?>
        </div>

        <div class="rooms">
            <?php
            echo $view->presentImages();
            ?>
        </div>
        <div class="labels">
            <?php
            echo $view->presentRoom(0);
            echo $view->presentRoom(1);
            echo $view->presentRoom(2);
            ?>
        </div>
        <div class="labels">
            <?php
            echo $view->presentShootArrow(0);
            echo $view->presentShootArrow(1);
            echo $view->presentShootArrow(2)
            ?>
        </div>

        <p id="game-body-bottom">  <?php echo $view->presentArrows(); ?></p>
    </div>
</body>
</html>