<?php
require '../lib/nurikabe.inc.php';
$gameController = new \Nurikabe\GameController($Nurikabe, $_POST, $site, $user);

$gameController->takeAction();

//echo "<p><a href=\"" . $gameController->getRedirect() . "\">" . $gameController->getRedirect() . "</a>";
header("location: " . $gameController->getRedirect());
exit;