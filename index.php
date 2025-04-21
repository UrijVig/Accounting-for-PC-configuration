<?php
    ini_set('display_errors', 1);
    ini_set('display_setup_errors', 1);
    error_reporting(E_ALL);

    define("DIR_TMPL", __DIR__ . "/public/templates/");
    define("MAIN_LAYOUT", "main");

    require_once 'core/route/route.php';
    require_once 'controllers/AbstractController.php';
    require_once 'controllers/MainController.php';
    require_once 'core/view/view.php';

    Route::start();