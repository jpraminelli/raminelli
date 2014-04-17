<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(dirname(__DIR__));

// Setup autoloading
include 'init_autoloader.php';

function pe($texto){
    echo '<pre>';
    print_r($texto);
    die;
}

if(!defined('WWWROOT')){
   define('WWWROOT', '/raminelli/public/'); 
}


// Run the application!
Zend\Mvc\Application::init(include 'config/application.config.php')->run();
