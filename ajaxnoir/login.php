<?php
$open = true;
require 'lib/site.inc.php';

if(isset($_COOKIE[LOGIN_COOKIE]) && $_COOKIE[LOGIN_COOKIE] != "") {
    $cookie = json_decode($_COOKIE[LOGIN_COOKIE], true);
    $cookies = new Noir\Cookies($site);
    $hash = $cookies->validate($cookie['user'], $cookie['token']);
    if($hash !== null) {
        $cookies->delete($hash);
    }

    $expire = time() - 3600;
    setcookie(LOGIN_COOKIE, "", $expire, "/");
}

$view = new Noir\View($site, $_GET, $_SESSION);
$view->setTitle("Ajax Noir Login");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $view->head(); ?>
    <script>
        $(document).ready(function() {
            new Login("form");
        });
    </script>
</head>
<body>
<?php
echo $view->header();
?>

<form class="login" method="post" action="post/login.php">
	<fieldset>
		<p><label for="user">User ID: </label>
			<input type="text" id="user" name="user"></p>
		<p><label for="password">Password: </label>
			<input type="password" id="password" name="password"></p>
		<p class="keep"><input type="checkbox" name="keep" id="keep">
			<label for="keep">Keep me logged on</label></p>
		<p class="buttons"><input type="submit" name="ok" value="Login">
	</fieldset>

	<div class="message"></div>
</form>

<?php
//echo $view->present();
echo $view->footer();
?>

</body>
</html>