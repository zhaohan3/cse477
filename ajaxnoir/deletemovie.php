<?php
require 'lib/site.inc.php';
$view = new Noir\DeleteView($site, $user, $_GET);
if($view->getRedirect() !== null) {
	//header("location: " . $view->getRedirect());
	exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $view->head(); ?>
</head>
<body>
<?php
echo $view->header();
echo $view->present();
echo $view->footer();
?>

</body>
</html>