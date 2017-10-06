<?php
require_once __DIR__ . '/../../lib/user.inc.php';

/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(Noir\Site $site) {
	// Set the time zone
	date_default_timezone_set('America/Detroit');

	$user = USER;
	$site->setRoot("/~$user/ajaxnoir");

	$host = $_SERVER['HTTP_HOST'];
	$site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=' . $user,
		$user,       		// Database user
		PASSWORD,     	// Database password
		'test_ajaxnoir_');  // Table prefix
};
