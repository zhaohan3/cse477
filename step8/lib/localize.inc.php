<?php

/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(Felis\Site $site) {
    date_default_timezone_set('America/Detroit');
    $site->setEmail('agbaydan@cse.msu.edu');
    $site->setRoot('/cse477/step8');
    $site->dbConfigure('mysql:host=localhost;dbname=agbaydan',
        'agbaydan',       // Database user
        'Zelda2017',     // Database password
        's8_');            // Table prefix
};
