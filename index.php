<?php
//Require files
require_once('vendor/autoload.php');


//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

require $_SERVER['DOCUMENT_ROOT'].'/../config.php';

//Instances
$f3 = Base::instance();
$validator = new Validate();
$dataLayer = new DataLayer($dbh);
$controller = new Controller($f3);

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//Define a default route
$f3->route('GET|POST /', function() {
    global $controller;
    $controller->home();
});

//Define a login route
$f3->route('GET|POST /login', function() {
    global $controller;
    $controller->login();
});

//Define a register route
$f3->route('GET|POST /register', function() {
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

//Define a budget admin route
$f3->route('GET|POST /admin', function() {
    global $controller;
    $controller->admin();
});

//Define a budget index route
$f3->route('GET|POST /logout', function() {
    global $controller;
    $controller->logout();
});

//Run Fat-Free
$f3->run();