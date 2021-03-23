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
    private $_subscription;

    /**
     * Subscription constructor.
     * @param $_price
     * @param $_description
     * @param $_priority
     * @param $_recurring
     * @param $_service
     */
    public function __construct($_price, $_description, $_priority, $_recurring, $_subscription)
    {
        parent::__construct($_price, $_description, $_priority, $_recurring, $_subscription);
        $this->_recurring = $_recurring;
        $this->_subscription = $_subscription;
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
    public function getSubscription()
    {
        return $this->_subscription;
    }

    /**
     * @param mixed $subscription
     */
    public function setSubscription($subscription): void
    {
        $this->_subscription = $subscription;
    }
}