<?php
require __DIR__ . '/lib/nurikabe.inc.php';
$view = new \Nurikabe\SolvedView($Nurikabe);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $view->presentHead(); ?>
</head>
<body>
<?php echo $view->present(); ?>
</body>
</html>