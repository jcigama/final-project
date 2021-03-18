<?php

/* model/data-layer.php
 * returns data for my app
 *
 */

class DataLayer
{
    private $_dbh;

    function __construct($dbh)
    {
        $this->_dbh = $dbh;
    }

    function insertBudget($budget)
    {
        //row data for name and starting amount
        $account = $_SESSION['account'];

        if(isset($_SESSION['account'])){
            $userNum = $account['userNum'];
        } else {
            $userNum = 0;
        }

        $sql = "INSERT INTO budget(baseFunds, description, startDate, endDate, priority, userNum)
                   VALUES (:baseFunds, :description, :startDate, :endDate, :priority, :userNum)";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(":baseFunds", $budget->getBaseFunds(), PDO::PARAM_INT);
        $statement->bindParam(":description", $budget->getDescription(), PDO::PARAM_STR);
        $statement->bindParam(":startDate", $budget->getStartDate(), PDO::PARAM_STR);
        $statement->bindParam(":endDate", $budget->getEndDate(), PDO::PARAM_STR);
        $statement->bindParam(":priority", $budget->getPriority(), PDO::PARAM_STR);
        $statement->bindParam(":userNum", $userNum, PDO::PARAM_INT);


        //execute
        $statement->execute();
    }

    function insertAccount($account)
    {
        $sql = "INSERT INTO account(userName, email, password, notification, situation, startingFunds, fname, lname, gender, age)
                   VALUES (:userName, :email, :password, :notification, :situation, :startingFunds, :fname, :lname, :gender, :age)";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(":userName", $account->getUserName(), PDO::PARAM_STR);
        $statement->bindParam(":email", $account->getEmail(), PDO::PARAM_STR);
        $statement->bindParam(":password", $account->getPassword(), PDO::PARAM_STR);
        $statement->bindParam(":notification", $account->getNotifications(), PDO::PARAM_BOOL);
        $statement->bindParam(":situation", $account->getSituation(), PDO::PARAM_STR);
        $statement->bindParam(":startingFunds", $account->getStartingFunds(), PDO::PARAM_STR);
        $statement->bindParam(":fname", $account->getFname(), PDO::PARAM_STR);
        $statement->bindParam(":lname", $account->getLname(), PDO::PARAM_STR);
        $statement->bindParam(":gender", $account->getGender(), PDO::PARAM_STR);
        $statement->bindParam(":age", $account->getAge(), PDO::PARAM_INT);

        //execute
        $statement->execute();
    }

    function insertExpense($expense)
    {
        $sql = "INSERT INTO expense(price, description, priority) VALUES (:price, :description, :priority)";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //bind the parameters
        $statement->bindParam(":price", $expense->getPrice(), PDO::PARAM_INT);
        $statement->bindParam(":description", $expense->getDescription(), PDO::PARAM_STR);
        $statement->bindParam(":priority", $expense->getPriority(), PDO::PARAM_STR);

        //execute
        $statement->execute();

    }

    // Get database queries
    function getAccounts()
    {
        $sql = "SELECT * FROM account";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function getAccountRow($username)
    {
        $sql = "SELECT * FROM account WHERE userName = '$username'";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    function getBudgets()
    {
        $sql = "SELECT * FROM budget";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function getBudgetsCards($userNum)
    {
        $sql = "SELECT * FROM budget WHERE userNum = '$userNum'";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function getBudgetCard($budgetNum)
    {
        $sql = "SELECT * FROM budget WHERE budgetNum = '$budgetNum'";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    function getExpense($budgetNum)
    {
        $sql = "SELECT * FROM budget WHERE budgetNum = '$budgetNum'";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function getPriorities()
    {
        return array("high", "medium", "low");
    }

    function getSituation()
    {
        return array("Choose your situation", "education", "bills", "leisure", "other");
    }

    /** getGender() returns an array of gender options
     *  @return array
     */
    function getGender()
    {
        return array("male", "female");
    }

    function getNotification()
    {
        return array("yes", "no");
    }
}