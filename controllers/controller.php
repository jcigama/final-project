<?php

class Controller
{
    private $_f3;

    /**
     * Controller constructor.
     * @param $f3
     */
    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    function home()
    {
        //Display a view
        $view = new Template();
        echo $view->render('views/home.html');
    }

    function login()
    {
        //Display a view
        $view = new Template();
        echo $view->render('views/login.html');
    }

    function register()
    {
        //Display a view
        $view = new Template();
        echo $view->render('views/register.html');

    }

    function budget()
    {
//        global $validator;
//        global $dataLayer;
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
            else {
                $this->_f3->set('errors["baseFunds"]', "*required*");
            }

            if (strlen($startDate) <= 8 && strlen($endDate) <= 8) {
                if ($startDate < $endDate) {
                    $budget->setStartDate($baseFunds);
                    $budget->setEndDate($baseFunds);
                }
            }


            if (strlen($startDate) > 8 || empty($startDate)) {
                $this->_f3->set('errors["startDate"]', "Start date format has to match mmddyyy");
            }
            else if ($startDate < $endDate) {
                $budget->setStartDate($baseFunds);
            }

            if (strlen(strlen($endDate) > 8) || empty($endDate)) {
                $this->_f3->set('errors["endDate"]', "End date format has to match mmddyyy");
            }
            else if ($startDate < $endDate) {
                $budget->setEndDate($baseFunds);
            }

            if (!is_null($priority)) {
                $budget->setPriority($priority);
            }
            else {
                $this->_f3->set('errors["priority"]', "Please select a priority");
            }

            $budget->setDescription($description);
        }

        //Display a view
        $view = new Template();
        echo $view->render('views/budget.html');
    }

    function budgetSummary()
    {
        //Display a view
        $_SESSION["budgetSummary"] = $_POST;
        $view = new Template();
        echo $view->render('views/budget-summary.html');
    }
}