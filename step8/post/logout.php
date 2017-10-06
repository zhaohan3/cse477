<?php
/**
 * Created by PhpStorm.
 * User: agbaydan
 * Date: 6/13/2017
 * Time: 7:23 PM
 */

require '../lib/site.inc.php';

unset($_SESSION['user']);
header("location: " . $site->getRoot());