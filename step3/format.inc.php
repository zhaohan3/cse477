<?php
function present_header($title) {
    $html = <<<HTML
    <header>
    <p id="links">
    <a href="welcome.php">New Game</a> &nbsp;
    <a href="game.php">Game</a> &nbsp;
    <a href="instructions.php">Instructions</a>
    </p>
    <h1>$title</h1>
    </header>
HTML;
    return $html;
}