<?php
require __DIR__ . '/lib/guessing.inc.php';
$view = new Guessing\GuessingView($guessing);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Guessing Game</title>
    <link href="guessing.css" type="text/css" rel="stylesheet" />
</head>
<body>
<!--    <fieldset>-->
<!--    <h3 id="guessing-game-head">Guessing Game</h3>-->
<!--    <form method="post" action="guessing-post.php" name="guessing-game" id="guessing-game">-->
<!--        <p>After 3 guesses you are too low!</p>-->
<!--        <p id="text">-->
<!--            <label for="guess">Guess:</label>-->
<!--            <input type="text" name="guess" id="guess">-->
<!--        </p>-->
<!--        <p><input type="submit" name="submit" id="submit" value="Submit"></p>-->
<!--        <p><input type="submit" name="new-game" id="new-game" value="New Game"></p>-->
<!--    </form>-->
<!--    </fieldset>-->
    <?php echo $view->present(); ?>

</body>
</html>

<?php
/**
 * Created by PhpStorm.
 * User: danielagbay
 * Date: 6/2/17
 * Time: 7:52 PM
 */

?>