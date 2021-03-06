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

    /**
     * Displays home page
     */
    function home()
    {
        global $dataLayer;

        //row data for name and starting amount
        if (isset($_SESSION['account'])) {
            $account = $_SESSION['account'];
        }

        //Retrieve user budgets
        $cards = $dataLayer->getBudgetsCards($account['userNum']);

        //If user wants to edit a budget, store budget number into a SESSION
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['budgetName'])) {
                $_SESSION['budgetName'] = $_POST['budgetName'];
                $this->_f3->reroute('confirm');
            }

            $_SESSION['budgetNum'] = $_POST['budgetInfo'];

            $this->_f3->reroute('edit');
        }

        $this->_f3->set('cards', isset($cards) ? $cards : "");

        //Display a home view
        $view = new Template();
        echo $view->render('views/home.html');
    }

    /**
     * Displays edit page
     */
    function edit()
    {
        global $dataLayer;
        global $validator;

        $budgetInfo = explode(",", $_SESSION['budgetNum']);
        $budgetNum = $budgetInfo[1];
        $budgetName = $budgetInfo[0];

        //Retrieve expenses of current budget
        $expenseData = $dataLayer->getExpense($budgetNum);
        $expenseTotal = $dataLayer->getTotalExpense($budgetNum);
        $budgetAmount = $dataLayer->getBudgetCard($budgetNum);

        //Set expenses in Fat-free hive for repeat block in HTML
        $this->_f3->set('expenses', $expenseData);
        $this->_f3->set('expensesTotal', $expenseTotal);
        $this->_f3->set('budgetAmount', $budgetAmount);
        $this->_f3->set('message', $_SESSION['message']);

        //If user decides to add an expense via modal
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //Adds funds
            if (isset($_POST['fundAmount'])) {
                $addFunds = $budgetAmount['baseFunds'] + $_POST['fundAmount'];
                $dataLayer->addFunds($budgetName, $addFunds);
                $this->_f3->reroute('edit');
            }

            //Directs user to delete prompt
            if (isset($_POST['budgetDelete'])) {
                $_SESSION['budgetName'] = $budgetName . "," . $budgetNum;
                $this->_f3->reroute('/confirm');
            }

            //Deletes individual expense
            if (isset($_POST['expenseNum'])) {
                $_SESSION['expenseNum'] = $_POST['expenseNum'];
                $_SESSION['expenseDescription'] = $dataLayer->getExpenseDescription($_POST['expenseNum']);
                $this->_f3->reroute('deleteExpense');
            }

            $price = $_POST['price'];
            $description = $_POST['description'];
            $priority = $_POST['priority'];
            $subscription = $_POST['subscription'];
            $interval = $_POST['interval'];

            //price validation
            if (!$validator->validPrice($price)) {
                $this->_f3->set('errors["price"]', "Price must be above $0.00");
            }

            //subscription validation | spoof prevention
            if (isset($subscription)) {
                if ($validator->validSubscriptions($subscription)) {
                    $this->_f3->set('errors["subscriptionSpoof"]', "Spoof attempt, prevented.");
                }
            }

            //interval validation | spoof prevention
            if (isset($interval)) {
                if ($validator->validIntervals($interval)) {
                    $this->_f3->set('errors["intervalSpoof"]', "Spoof attempt, prevented.");
                }
            }


            //if no errors set in Fat-free 'errors' hive
            if (empty($this->_f3->get('errors'))) {

                //create a new expense object
                if (isset($subscription) && isset($interval)) {
                    $expense = new Subscription($price, $description, $priority);
                    $expense->setSubscription($subscription);
                    $expense->setRecurring($interval);
                } else {
                    $expense = new Expense($price, $description, $priority);
                }

                //Insert object into database
                $dataLayer->insertExpense($expense, $budgetNum);

                //Refresh page after insertion
                $this->_f3->reroute('edit');
            }

            //set priority choice in hive to check in html
            $this->_f3->set('priorityChoice', $priority);
            $this->_f3->set('userSubscription', $subscription);
            $this->_f3->set('userInterval', $interval);
        }

        //get array from data layer
        $this->_f3->set('priorities', $dataLayer->getPriorities());
        $this->_f3->set('subscriptions', $dataLayer->getSubscriptions());
        $this->_f3->set('intervals', $dataLayer->getInterval());

        //Set budget name into Fat-free hive
        $this->_f3->set('budgetName', $budgetName);

        //Display a view
        $view = new Template();
        echo $view->render('views/edit.html');
    }

    /**
     * Displays login page
     */
    function login()
    {
        global $dataLayer;

        if (isset($_SESSION['account'])) {
            session_destroy();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $account = $dataLayer->getAccountRow($username);
            if (empty($username) && empty($password)) {
                $this->_f3->set('loginError', "Please enter your username and password");
            } else if (empty($username))  {
                $this->_f3->set('loginError', "Please enter your username");
            } else if (empty($password)) {
                $this->_f3->set('loginError', "Please enter your password");

            }
            else if ($username == $account['userName'] && $password == $account['password']) {
                $_SESSION['account'] = $account;
                $this->_f3->reroute('/');
            } else {
                $this->_f3->set('loginError', "Invalid username or password");
            }

            $this->_f3->set('password', $password);
            $this->_f3->set('username', $username);
        }

        //Display a login view
        $view = new Template();
        echo $view->render('views/login.html');
    }

    /**
     * Displays register page
     */
    function register()
    {

        global $validator;
        global $dataLayer;

        //destroy session
        session_destroy();

        //get array
        $this->_f3->set('genders', $dataLayer->getGender());

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $userEmail = $_POST['email'];
            $userPassword = $_POST['password'];
            $confirmPassword = $_POST['confirmPassword'];
            $userFname = $_POST['fname'];
            $userLname = $_POST['lname'];

            if (isset($_POST['gender'])) {
                $userGender = $_POST['gender'];
            }

            if (isset($_POST['otherGenderInput'])) {
                $userGender = $_POST['otherGenderInput'];
            }

            $userAge = $_POST['age'];

            //validate username
            if (!$validator->validUsername($username)) {
                $this->_f3->set('errors["username"]', "Please enter a username that is longer than 3 characters");
            }

            //validate email
            if (!$validator->validEmail($userEmail)) {
                $this->_f3->set('errors["email"]', "Email must contain an @.");
            }

            //validate password
            if (!$validator->validPassword($userPassword)) {
                $this->_f3->set('errors["password"]', "Password cannot be empty and has to be longer than 5 characters.");
            }

            //validate confirm password
            if (!$validator->passwordConfirmation($userPassword, $confirmPassword)) {
                $this->_f3->set('errors["confirmPassword"]', "Passwords don't match.");
            }

            //validate first name
            if (!$validator->validFname($userFname)) {
                $this->_f3->set('errors["fname"]', "Please enter a first name that only contains characters");
            }

            //validate last name
            if (!$validator->validLname($userLname)) {
                $this->_f3->set('errors["lname"]', "Please enter a last name that only contains characters");
            }

            //validate gender | spoof protection
            if (!isset($userGender)) {
                $this->_f3->set('errors["gender"]', "Please choose gender.");
            }

            //validate age
            if ($userAge == "") {
                $this->_f3->set('errors["age"]', "Please enter age.");
            }

            //validate age
            if ($userAge < 13) {
                $this->_f3->set('errors["age"]', "You must at least 13 years of age.");
            }


            //if there are no errors, redirect to /profile
            if (empty($this->_f3->get('errors'))) {

                //instantiate budget with parameters
                $account = new Account($username, $userEmail, $userPassword, $userFname, $userLname, $userGender, $userAge);

                $_SESSION['account'] = $account;
                $dataLayer->insertAccount($_SESSION['account']);

                $this->_f3->reroute('/');
            }
        }

        //make form sticky
        $this->_f3->set('username', isset($username) ? $username : "");
        $this->_f3->set('userEmail', isset($userEmail) ? $userEmail : "");
        $this->_f3->set('userPassword', isset($userPassword) ? $userPassword : "");
        $this->_f3->set('confirmPassword', isset($confirmPassword) ? $confirmPassword : "");
        $this->_f3->set('userEmail', isset($userEmail) ? $userEmail : "");
        $this->_f3->set('userFname', isset($userFname) ? $userFname : "");
        $this->_f3->set('userLname', isset($userLname) ? $userLname : "");
        $this->_f3->set('userGender', isset($userGender) ? $userGender : "");
        $this->_f3->set('userAge', isset($userAge) ? $userAge : "");

        //Display a register view
        $view = new Template();
        echo $view->render('views/register.html');
    }

    /**
     * Displays budget page
     */
    function budget()
    {
        global $validator;
        global $dataLayer;

        //row data for name and starting amount
        if (isset($_SESSION['account'])) {
            $account = $_SESSION['account'];
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $baseFunds = $_POST['baseFunds'];
            $budgetName = $_POST['budgetName'];
            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];

            // baseFunds validation
            if (!$validator->baseFundsValidation($baseFunds)) {
                $this->_f3->set('errors["baseFunds"]', "Please provide a base fund");
            }

            //startDate validation
            if (!$validator->dateValidDateStart($startDate)) {
                $this->_f3->set('errors["startDate"]', "Please provide an start date");
            }

            //endDate validation
            if (!$validator->dateValidDateEnd($endDate)) {
                $this->_f3->set('errors["endDate"]', "Please provide an end date");
            }

            //startDate < endDate validation
            if ($validator->validDates($startDate, $endDate)) {
                $this->_f3->set('errors["endDate"]', "End date can't be before start date.");
            }


            if (empty($budgetName)) {
                $this->_f3->set('errors["budgetName"]', "Name for budget required.");
            }

            echo $startDate;
            echo $endDate;

            //if no errors set in f3 hive, store variables in sessions and set in $budget class
            if (empty($this->_f3->get('errors'))) {

                $startDate =
                    substr((string)$startDate, 0, 4) . "-" .
                    substr((string)$startDate, 4, 2) . "-" .
                    substr((string)$startDate, 6, 2);

                $endDate =
                    substr((string)$endDate, 0, 4) . "-" .
                    substr((string)$endDate, 4, 2) . "-" .
                    substr((string)$endDate, 6, 2);


                //instantiate budget with parameters
                $budget = new Budget($baseFunds, $budgetName, $startDate, $endDate);

                //save data to session
                $_SESSION['budget'] = $budget;

                $dataLayer->insertBudget($_SESSION['budget']);

                $this->_f3->reroute('/');
            }

        }

        //Sticky data
        $this->_f3->set('baseFunds', isset($baseFunds) ? $baseFunds : "");
        $this->_f3->set('budgetName', isset($budgetName) ? $budgetName : "");
        $this->_f3->set('startDate', isset($startDate) ? $startDate : "");
        $this->_f3->set('endDate', isset($endDate) ? $endDate : "");

        //Display a view
        $view = new Template();
        echo $view->render('views/budget.html');
    }

    /**
     * Displays budget summary page
     */
    function budgetSummary()
    {
        //Display a view
        $_SESSION["budgetSummary"] = $_POST;
        $view = new Template();
        echo $view->render('views/budget-summary.html');

        //clear session
        session_destroy();
    }

    /**
     * Displays admin page
     */
    function admin()
    {
        global $dataLayer;
        $accounts = $dataLayer->getAccounts();
        $budgets = $dataLayer->getBudgets();
        $expenses = $dataLayer->getExpenses();

        $this->_f3->set('accounts', $accounts);
        $this->_f3->set('budgets', $budgets);
        $this->_f3->set('expenses', $expenses);

        $view = new Template();
        echo $view->render('views/admin.html');
    }

    /**
     * Displays confirm page
     */
    function confirm()
    {
        global $dataLayer;

        $budgetInfo = explode(",", $_SESSION['budgetName']);
        $budgetName = $budgetInfo[0];
        $budgetNum = $budgetInfo[1];

        $this->_f3->set('budgetName', $budgetName);
        $this->_f3->set('budgetNum', $budgetNum);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (isset($_POST['delete'])) {
                if ($_POST['delete'] == 'yes') {
                    $dataLayer->deleteExpenses($budgetNum);
                    $dataLayer->deleteBudget($budgetNum);
                    echo "deleted";
                    $this->_f3->reroute('/');
                } else if ($_POST['delete'] == 'no') {
                    echo "not deleted";
                    $this->_f3->reroute('/edit');
                }
            }
        }

        $view = new Template();
        echo $view->render('views/confirm.html');
    }

    /**
     * Confirm route for expense deletion
     */
    function deleteExpense()
    {
        global $dataLayer;

        $expenseNum = $_SESSION['expenseNum'];
        $expenseDescription = $_SESSION['expenseDescription'];

        $this->_f3->set('expenseNum', $expenseNum);
        $this->_f3->set('expenseDescription', $expenseDescription);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (isset($_POST['delete'])) {
                if ($_POST['delete'] == 'yes') {
                    $dataLayer->deleteExpense($expenseNum);
                    echo "deleted";
                    $this->_f3->reroute('/edit');
                } else if ($_POST['delete'] == 'no') {
                    echo "not deleted";
                    $this->_f3->reroute('/edit');
                }
            }
        }

        $view = new Template();
        echo $view->render('views/deleteExpense.html');
    }
}