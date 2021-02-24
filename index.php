<?php
//Require files
require_once('vendor/autoload.php');


//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Instances
$f3 = Base::instance();
$validator = new Validate();
$dataLayer = new DataLayer();
$budget = new Budget();
$controller = new Controller($f3);

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//Define a default route
$f3->route('GET /', function() {
    global $controller;
    $controller->home();
});

//Define a login route
$f3->route('GET /login', function() {
    global $controller;
    $controller->login();
});

//Define a register route
$f3->route('GET /register', function() {
    global $controller;
    $controller->register();
});

//Define a budget route
$f3->route('GET|POST /budget', function($f3) {
    global $controller;
    $controller->budget();
});

//Define a budget summary route
$f3->route('GET|POST /budgetSummary', function() {
    global $controller;
    $controller->budgetSummary();
});

//Run Fat-Free
$f3->run();