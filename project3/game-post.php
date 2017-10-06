<?php
require __DIR__ . '/lib/nurikabe.inc.php';
$gameController = new \Nurikabe\GameController($Nurikabe, $_POST);

$gameController->takeAction();

//echo "<p><a href=\"" . $gameController->getRedirect() . "\">" . $gameController->getRedirect() . "</a>";
header("location: " . $gameController->getRedirect());
exit;