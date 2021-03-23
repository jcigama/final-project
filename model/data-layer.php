<?php

/* model/data-layer.php
 * returns data for my app
 *
 */

class DataLayer
{
    private $_dbh;

    /**
     * DataLayer constructor.
     * @param $dbh
     */
    function __construct($dbh)
    {
        $this->_dbh = $dbh;
    }

    /**
     * Inserts data from budget into the database.
     * @param $budget
     */
    function insertBudget($budget)
    {
        //row data for name and starting amount
        $account = $_SESSION['account'];

        if(isset($_SESSION['account'])){
            $userNum = $account['userNum'];
        } else {
            $userNum = 0;
        }

        $sql = "INSERT INTO budget(baseFunds, budgetName, startDate, endDate, priority, userNum)
                   VALUES (:baseFunds, :budgetName, :startDate, :endDate, :priority, :userNum)";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(":baseFunds", $budget->getBaseFunds(), PDO::PARAM_INT);
        $statement->bindParam(":budgetName", $budget->getBudgetName(), PDO::PARAM_STR);
        $statement->bindParam(":startDate", $budget->getStartDate(), PDO::PARAM_STR);
        $statement->bindParam(":endDate", $budget->getEndDate(), PDO::PARAM_STR);
        $statement->bindParam(":priority", $budget->getPriority(), PDO::PARAM_STR);
        $statement->bindParam(":userNum", $userNum, PDO::PARAM_INT);


        //execute
        $statement->execute();
    }

    /**
     * Inserts data from account into the database
     * @param $account
     */
    function insertAccount($account)
    {
        $sql = "INSERT INTO account(userName, email, password, fname, lname, gender, age)
                   VALUES (:userName, :email, :password, :fname, :lname, :gender, :age)";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(":userName", $account->getUserName(), PDO::PARAM_STR);
        $statement->bindParam(":email", $account->getEmail(), PDO::PARAM_STR);
        $statement->bindParam(":password", $account->getPassword(), PDO::PARAM_STR);
        $statement->bindParam(":fname", $account->getFname(), PDO::PARAM_STR);
        $statement->bindParam(":lname", $account->getLname(), PDO::PARAM_STR);
        $statement->bindParam(":gender", $account->getGender(), PDO::PARAM_STR);
        $statement->bindParam(":age", $account->getAge(), PDO::PARAM_INT);

        //execute
        $statement->execute();
    }

    /**
     * Inserts data from expense into the database using the corresponding budget number
     * @param $expense
     * @param $budgetNum
     */
    function insertExpense($expense, $budgetNum)
    {
        $sql = "INSERT INTO expense(price, description, priority, budgetNum) VALUES (:price, :description, :priority, :budgetNum)";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //bind the parameters
        $statement->bindParam(":price", $expense->getPrice(), PDO::PARAM_INT);
        $statement->bindParam(":description", $expense->getDescription(), PDO::PARAM_STR);
        $statement->bindParam(":priority", $expense->getPriority(), PDO::PARAM_STR);
        $statement->bindParam(":budgetNum", $budgetNum, PDO::PARAM_INT);

        //execute
        $statement->execute();
    }

    /**
     * Adds funds to user's budget amount then updates the amount in database
     * @param $budgetName
     * @param $addFunds
     */
    function addFunds($budgetName, $addFunds)
    {
        $sql = "UPDATE budget SET baseFunds = :new WHERE budgetName = :old";

        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':old', $budgetName, PDO::PARAM_STR);
        $statement->bindParam(':new', $addFunds, PDO::PARAM_INT);

        $statement->execute();

        echo "Funds updated!";
    }

    /**
     * Deletes expense from expense table
     * @param $budgetNum
     */
    function deleteExpenses($budgetNum)
    {
        $sql = "DELETE FROM expense WHERE budgetNum = :budgetNum";

        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':budgetNum', $budgetNum, PDO::PARAM_INT);

        $statement->execute();
    }

    /**
     * @param $budgetNum
     */
    function deleteExpense($expenseNum)
    {
        $sql = "DELETE FROM expense WHERE expenseNum = :expenseNum";

        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':expenseNum', $expenseNum, PDO::PARAM_INT);

        $statement->execute();
    }

    /**
     * Deletes budget from user's account
     * @param $budgetNum
     */
    function deleteBudget($budgetNum)
    {
        $sql = "DELETE FROM budget WHERE budgetNum = :budgetNum";

        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':budgetNum', $budgetNum, PDO::PARAM_INT);

        $statement->execute();
    }

    /**
     * Gets all accounts from the database
     * @return mixed
     */
    function getAccounts()
    {
        $sql = "SELECT * FROM account";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Gets a specific account from the database
     * @param $username
     * @return mixed
     */
    function getAccountRow($username)
    {
        $sql = "SELECT * FROM account WHERE userName = '$username'";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Gets all budgets from the database
     * @return mixed
     */
    function getBudgets()
    {
        $sql = "SELECT * FROM budget";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Gets all budgets that correspond to a specific user
     * @param $userNum
     * @return mixed
     */
    function getBudgetsCards($userNum)
    {
        $sql = "SELECT * FROM budget WHERE userNum = '$userNum'";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Gets a specific budget from database
     * @param $budgetNum
     * @return mixed
     */
    function getBudgetCard($budgetNum)
    {
        $sql = "SELECT * FROM budget WHERE budgetNum = '$budgetNum'";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Gets all expenses corresponding to a specific budget
     * @param $budgetNum
     * @return mixed
     */
    function getExpense($budgetNum)
    {
        $sql = "SELECT * FROM expense WHERE budgetNum = '$budgetNum'";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Gets all expenses from the database
     * @return mixed
     */
    function getExpenses()
    {
        $sql = "SELECT * FROM expense";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    function getExpenseDescription($expenseNum)
    {
        $sql = "SELECT description FROM expense WHERE expenseNum = :expenseNum";

        $statement = $this->_dbh->prepare($sql);

        $statement->bindParam(':expenseNum', $expenseNum, PDO::PARAM_INT);

        $statement->execute();

        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Gets the sum of all the expenses from a specific budget
     * @param $budgetNum
     * @return mixed
     */
    function getTotalExpense($budgetNum)
    {
        $sql = "SELECT SUM(price) AS total FROM expense WHERE budgetNum = '$budgetNum'";

        $statement = $this->_dbh->prepare($sql);

        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * getPriorities() returns an array of priority options
     * @return string[]
     */
    function getPriorities()
    {
        return array("high", "medium", "low");
    }

    /** getGender() returns an array of gender options
     *  @return array
     */
    function getGender()
    {
        return array("male", "female", "other");
    }

    /**
     * getSubscription() returns an array of subscription services
     * @return array
     */
    function getSubscription()
    {
        return array("Choose a subscription", "Netflix", "Disney+", "Hulu", "Crunchyroll", "Other");
    }

    /**
     * getInterval() returns an array of typical subscritpion intervals
     * @return array
     */
    function getInterval()
    {
        return array("1 month", "3 months", "1 year");
    }

}