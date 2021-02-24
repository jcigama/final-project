<?php

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Start a session
session_start();

//Require files
require_once('vendor/autoload.php');

//Instances
$f3 = Base::instance();
$budget = new Budget();

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

//Define a register route
$f3->route('GET /register', function() {
    //Display a view
    $view = new Template();
    echo $view->render('views/register.html');
});

//Define a budget route
$f3->route('GET|POST /budget', function() {

    global $budget;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        var_dump($_POST);
        $baseFunds = $_POST['baseFunds'];
        $description = $_POST['description'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $priority = $_POST['priority'];

        if (!empty($funds)) {
            $budget->setBaseFunds($baseFunds);
        }

        if (!empty($funds)) {
            $budget->setBaseFunds($baseFunds);
        }
    }

    //Display a view
    $view = new Template();
    echo $view->render('views/budget.html');
});

//Define a budget summary route
$f3->route('GET|POST /budgetSummary', function() {
    //Display a view
    $_SESSION["budgetSummary"] = $_POST;
    $view = new Template();
    echo $view->render('views/budget-summary.html');
});

//Run Fat-Free
$f3->run();