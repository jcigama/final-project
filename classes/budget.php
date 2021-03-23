<?php

/**
 * The Budget class represents a user's budget in our expense tracker.
 *
 * The Budget class represents a user's budget with a base fund, description,
 * budget name, start date, end date, and priority.
 * @author Joseph Igama <jigama2@mail.greenriver.edu>
 * @author Alisa Llavore <allavore@mail.greenriver.edu>
 * @copyright 2021
 */
class Budget
{

    private $_baseFunds;
    private $_budgetName;
    private $_startDate;
    private $_endDate;

    /**
     * Budget constructor.
     * @param $_baseFunds
     * @param $_budgetName
     * @param $_startDate
     * @param $_endDate
     */
    public function __construct($_baseFunds, $_budgetName, $_startDate, $_endDate)
    {
        $this->_baseFunds = $_baseFunds;
        $this->_budgetName = $_budgetName;
        $this->_startDate = $_startDate;
        $this->_endDate = $_endDate;
    }

    /**
     * @return mixed
     */
    public function getBaseFunds()
    {
        return $this->_baseFunds;
    }

    /**
     * @return mixed
     */
    public function getBudgetName()
    {
        return $this->_budgetName;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->_startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->_endDate;
    }

    /**
     * @param mixed $baseFunds
     */
    public function setBaseFunds($baseFunds): void
    {
        $this->_baseFunds = $baseFunds;
    }

    /**
     * @param mixed $budgetName
     */
    public function setBudgetName($budgetName): void
    {
        $this->_budgetName = $budgetName;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate): void
    {
        $this->_startDate = $startDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate): void
    {
        $this->_endDate = $endDate;
    }
}