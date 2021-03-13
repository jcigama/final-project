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

        $sql = "INSERT INTO budget(baseFunds, description, startDate, endDate, priority)
                   VALUES (:baseFunds, :description, :startDate, :endDate, :priority)";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(":baseFunds", $budget->getBaseFunds(), PDO::PARAM_INT);
        $statement->bindParam(":description", $budget->getDescription(), PDO::PARAM_STR);
        $statement->bindParam(":startDate", $budget->getStartDate(), PDO::PARAM_STR);
        $statement->bindParam(":endDate", $budget->getEndDate(), PDO::PARAM_STR);
        $statement->bindParam(":priority", $budget->getPriority(), PDO::PARAM_STR);

        //execute
        $statement->execute();
    }

    function insertAccount($account)
    {
        $sql = "INSERT INTO budget(baseFunds, description, startDate, endDate, priority)
                   VALUES (:baseFunds, :description, :startDate, :endDate, :priority)";

        //prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //Bind the parameters
        $statement->bindParam(":baseFunds", $budget->getBaseFunds(), PDO::PARAM_INT);
        $statement->bindParam(":description", $budget->getDescription(), PDO::PARAM_STR);
        $statement->bindParam(":startDate", $budget->getStartDate(), PDO::PARAM_STR);
        $statement->bindParam(":endDate", $budget->getEndDate(), PDO::PARAM_STR);
        $statement->bindParam(":priority", $budget->getPriority(), PDO::PARAM_STR);

        //execute
        $statement->execute();
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

