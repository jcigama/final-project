<?php

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require files
require_once('vendor/autoload.php');

$f3 = Base::instance();
//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//Define a default route
$f3->route('GET /', function() {
    //Display a view
    $view = new Template();
    echo $view->render('views/home.html');
});

//Define a login route
$f3->route('GET /login', function() {
    //Display a view
    $view = new Template();
    echo $view->render('views/login.html');
});

//Run Fat-Free
$f3->run();