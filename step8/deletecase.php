<?php
require 'lib/site.inc.php';
$view = new Felis\DeleteCaseView($site, $_GET);
if(!$view->protect($site, $user)) {
    header("location: " . $view->getProtectRedirect());
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php echo $view->head(); ?>
</head>

<body>
<div class="case">
    <?php
    echo $view->header();
    echo $view->present();
    echo $view->footer();
    ?>

<!--<form>-->
<!--	<fieldset>-->
<!--		<legend>Delete?</legend>-->
<!--		<p>Are you sure absolutely certain beyond a shadow of-->
<!--			a doubt that you want to delete case 15-1234?</p>-->
<!---->
<!--		<p>Speak now or forever hold your peace.</p>-->
<!---->
<!--		<p><input type="submit" value="Yes"> <input type="submit" value="No"></p>-->
<!---->
<!--	</fieldset>-->
<!--</form>-->

</div>

</body>
</html>
