<?php

/**
 * The Expense class represents an expense that is in a user's budget.
 *
 * The Expense class represents an expense that is in a user's budget with
 * a price, description, and priority.
 * @author Joseph Igama <jigama2@mail.greenriver.edu>
 * @author Alisa Llavore <allavore@mail.greenriver.edu>
 * @copyright 2021
 */
class Subscription extends Expense {

    private $_recurring;
    private $_service;

    /**
     * Subscription constructor.
     * @param $_price
     * @param $_description
     * @param $_priority
     * @param $_recurring
     * @param $_service
     */
    public function __construct($_price, $_description, $_priority, $_recurring, $_service)
    {
        parent::__construct($_price, $_description, $_priority, $_recurring, $_service);
        $this->_recurring = $_recurring;
        $this->_service = $_service;
    }

    /**
     * @return mixed
     */
    public function getRecurring()
    {
        return $this->_recurring;
    }

    /**
     * @param mixed $recurring
     */
    public function setRecurring($recurring): void
    {
        $this->_recurring = $recurring;
    }

    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->_service;
    }

    /**
     * @param mixed $service
     */
    public function setService($service): void
    {
        $this->_service = $service;
    }
}