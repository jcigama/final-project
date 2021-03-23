<?php

/* model/validate.php
 * returns validation functions for my app
 *
 */

class Validate
{
    private $_dataLayer;

    /**
     * Validate constructor.
     * @param $_dataLayer
     */
    public function __construct()
    {
        $this->_dataLayer = new DataLayer($dbh);
    }

    /**
     * Checks if baseFunds is not empty
     * @param $baseFunds
     * @return bool
     */
    public function baseFundsValidation($baseFunds)
    {
        return !empty($baseFunds);
    }

    /**
     * Checks if startDate is not empty and is 8 characters long
     * @param $startDate
     * @return bool
     */
    public function dateValidDateStart($startDate)
    {
        return strlen($startDate) == 8 && !empty($startDate);
    }

    /**
     * Checks if endDate is not empty and is 8 characters long
     * @param $endDate
     * @return bool
     */
    public function dateValidDateEnd($endDate)
    {
        return strlen($endDate) == 8 && !empty($endDate);
    }

    /**
     * Checks if startDate is earlier than the endDate
     * @param $startDate
     * @param $endDate
     * @return bool
     */
    public function validDates($startDate, $endDate)
    {
        return $startDate > $endDate;
    }

    /**
     * @param $subscription
     * @return bool
     */
    function validSubscription($subscription)
    {
        return isset($subscription);
    }

    /**
     * @param $checkSpoof
     * @return bool
     */
    function validSubscriptions($checkSpoof)
    {
        $validSubscriptions = $this->_dataLayer->getSubscriptions();

        if (in_array($checkSpoof, $validSubscriptions)) {
            return false;
        }
        return true;
    }

    /**
     * Checks if interval is set
     * @param $priority
     * @return bool
     */
    public function validInterval($interval)
    {
        return isset($interval);
    }

    /**
     * Checks intervals against intervals array to protect against spoof
     * protection
     * @param $checkSpoof
     * @return bool
     */
    function validIntervals($checkSpoof)
    {
        $validIntervals = $this->_dataLayer->getInterval();

        if (in_array($checkSpoof, $validIntervals)) {
            return false;
        }
        return true;
    }

    //-------Registration Page Validation

    /**
     * Checks to see if the username is not empty and is longer than
     * 3 characters
     * @param $username
     * @return bool
     */
    function validUsername($username)
    {
        return !empty($username) && strlen($username) > 3;
    }

    /**
     * validAEmail checks to see that an email address is valid
     * REQUIRED
     * #param String $email
     * @return boolean
     */
    function validEmail($email)
    {
        return !empty($email) && preg_match("/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/", $email);
    }

    /**
     * Checks to see if the password is not empty and is longer than
     * 5 characters
     * @param $password
     * @return bool
     */
    function validPassword($password)
    {
        return !empty($password) && strlen($password) > 5;
    }

    /**
     * Checks if confirm password is the same as the
     * password previously entered
     * @param $password
     * @param $confirm
     * @return bool
     */
    function passwordConfirmation($password, $confirm)
    {
        return $password === $confirm;
    }

    /**
     * validName checks to see that the string is all alphabetic characters
     * REQUIRED
     * #param String $name
     * @return boolean
     */
    function validFname($fname)
    {
        return !empty($fname) && ctype_alpha($fname);
    }

    /**
     * Checks to see that the string is all alphabetic characters
     * @param $lname
     * @return bool
     */
    function validLname($lname)
    {
        return !empty($lname) && ctype_alpha($lname);
    }

    /**
     * Checks to see if price is greater than 0 and is not empty
     * @param $price
     * @return bool
     */
    function validPrice($price)
    {
        return $price > 0 && !empty($price);
    }

}