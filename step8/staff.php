<?php
require 'lib/site.inc.php';
$view = new Felis\StaffView();
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
<div class="staff">
    <?php echo $view->header(); ?>
	<p class="date">4:44pm Tuesday, Feb 16, 2016</p>
	<p>Welcome, <em>whoever you are...</em></p>
<p>This is the main page for Felis Investigations staff. The options available to you depend on your
access privileges. Please contact your supervisor for any modification of access rights in the
system.</p>
<div class="menu">
	<p><a href="cases.php"><img src="images/sitting200.png" width="137" height="200" alt="Sitting Cat"></a> <a href="cases.php">Cases</a></p>
	<p><a href="">Culprits</a> <a href=""><img src="images/evil-cat200.png" width="138" height="200" alt="Evil Cat"></a></p>
	<p><a href="users.php"><img src="images/sleeping200.png" width="282" height="200" alt="Sleepy Cat"></a> <a href="users.php">Users</a></p>
</div>

    <?php echo $view->footer(); ?>

</div>

</body>
</html>
