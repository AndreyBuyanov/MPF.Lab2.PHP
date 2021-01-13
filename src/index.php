<?php
    // Настройки
    ini_set('display_errors', 0);
    //error_reporting(E_ALL);

    // Подключение файловой системы
    define('ROOT', dirname(__FILE__));
    require_once(ROOT.'/Components/Autoload.php');

    // Вызов Router
    $router = new Router();
    $router->run();



