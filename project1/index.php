<?php
require __DIR__ . '/lib/nurikabe.inc.php';
$view = new \Nurikabe\IndexView($Nurikabe);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nifty Nurikabe</title>
    <link href="styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php echo $view->present(); ?>
</body>
</html>