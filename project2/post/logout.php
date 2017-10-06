<?php
/**
 * Created by PhpStorm.
 * User: agbaydan
 * Date: 6/21/2017
 * Time: 12:41 AM
 */

require '../lib/nurikabe.inc.php';

unset($_SESSION[Nurikabe\User::SESSION_NAME]);
header("location: " . $site->getRoot());