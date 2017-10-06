<?php
require_once __DIR__ . '/user.inc.php';

/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(Noir\Site $site) {
	// Set the time zone
	date_default_timezone_set('America/Detroit');

	/*
	 * Determine the server directory for this site
	 */
	$regexp = "#~" . USER . "/([^/]*)(/|$)#";

	preg_match($regexp, $_SERVER["REQUEST_URI"], $matches);
	if(count($matches) > 1) {
		$dir = $matches[1];
	} else {
		$dir = "ajaxnoir";
	}

	$site->setRoot("/~" . USER . "/$dir");

	$host = $_SERVER['HTTP_HOST'];
	$site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=' . USER,
		USER,       // Database user
		PASSWORD,     // Database password
		'ajaxnoir_');            // Table prefix
};
