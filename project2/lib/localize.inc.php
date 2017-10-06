<?php
/**
 * Created by PhpStorm.
 * User: agbaydan
 * Date: 6/19/2017
 * Time: 11:28 PM
 */

return function(Nurikabe\Site $site) {
    date_default_timezone_set('America/Detroit');
    $site->setEmail('agbaydan@cse.msu.edu');
    $site->setRoot('/~agbaydan/project2');
    $site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=agbaydan',
        'agbaydan',       // Database user
        'Zelda2017',     // Database password
        'proj2_');            // Table prefix
};