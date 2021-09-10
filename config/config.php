<?php


    if (!defined('DC')) {
        define('DC', DIRECTORY_SEPARATOR);
    }
    
    define('APP_PATH', realpath(dirname(__FILE__)).DC.'..');
    define('VIEW_PATH', APP_PATH.DC."Views".DC);
    define('ROUTE_PATH', APP_PATH.DC."routes".DC);
 
    define('DATABASE_HOST_NAME', 'mysql:host=localhost;');
    define('DATABASE_USER_NAME', 'root');
    define('DATABASE_PASSWORD', 'hamza063018092');
    define('DATABASE_DB_NAME', 'dbname=test');
