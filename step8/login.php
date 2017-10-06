<?php
$open = true;;
require 'lib/site.inc.php';
$view = new Felis\LoginView($_SESSION, $_GET);
$view->setTitle('Felis Investigations');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $view->head(); ?>
</head>

<body>
<div class="login">
    <?php
    echo $view->header();
    echo $view->presentForm();
    echo $view->footer();
    ?>

</div>

</body>
</html>
