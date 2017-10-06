<?php

return function(Nurikabe\Site $site) {
    date_default_timezone_set('America/Detroit');
    $site->setEmail('agbaydan@cse.msu.edu');
    $site->setRoot('/~agbaydan/project2');
    $site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=agbaydan',
        'agbaydan',       // Database user
        'Zelda2017',     // Database password
        'testproj2_');            // Table prefix
};