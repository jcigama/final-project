<?php

/**
 * The Subscription class represents subscription that extends the expense class.
 *
 * The Subscription class represents subscription that extends the expense class
 * with a recurring interval, and the type of subscription.
 * @author Joseph Igama <jigama2@mail.greenriver.edu>
 * @author Alisa Llavore <allavore@mail.greenriver.edu>
 * @copyright 2021
 */
class Subscription extends Expense {

    private $_recurring;
    private $_subscription;

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
    public function setRecurring($recurring)
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
    public function setSubscription($subscription)
    {
        $this->_subscription = $subscription;
    }
}