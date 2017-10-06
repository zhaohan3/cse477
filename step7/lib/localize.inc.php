<?php
/**
 * Created by PhpStorm.
 * User: agbaydan
 * Date: 6/12/2017
 * Time: 11:25 PM
 */

/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(Felis\Site $site) {
    date_default_timezone_set('America/Detroit');
    $site->setEmail('agbaydan@cse.msu.edu');
    $site->setRoot('/cse477/step7');
    $site->dbConfigure('mysql:host=localhost;dbname=agbaydan',
        'agbaydan',       // Database user
        'Zelda2017',     // Database password
        '');            // Table prefix
};
