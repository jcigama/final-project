<?php

/**
 * The Account class represents an account in our expense tracker.
 *
 * The Account class represents an account with a username, email, password,
 * notification, first name, last name, gender, age, starting funds, and
 * situation.
 * @author Joseph Igama <jigama2@mail.greenriver.edu>
 * @author Alisa Llavore <allavore@mail.greenriver.edu>
 * @copyright 2021
 */
class Account {

    private $_userName;
    private $_email;
    private $_password;
    private $_fname;
    private $_lname;
    private $_gender;
    private $_age;

    /**
     * Person constructor.
     * @param $_userName
     * @param $_email
     * @param $_password
     * @param $_fname
     * @param $_lname
     * @param $_gender
     * @param $_age
     */
    public function __construct($_userName, $_email, $_password, $_fname, $_lname, $_gender, $_age)
    {
        $this->_userName = $_userName;
        $this->_email = $_email;
        $this->_password = $_password;
        $this->_fname = $_fname;
        $this->_lname = $_lname;
        $this->_gender = $_gender;
        $this->_age = $_age;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->_userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->_userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @return mixed
     */
    public function getFname()
    {
        return $this->_fname;
    }

    /**
     * @param mixed $fname
     */
    public function setFname($fname)
    {
        $this->_fname = $fname;
    }

    /**
     * @return mixed
     */
    public function getLname()
    {
        return $this->_lname;
    }

    /**
     * @param mixed $lname
     */
    public function setLname($lname)
    {
        $this->_lname = $lname;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->_gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender)
    {
        $this->_gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->_age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age)
    {
        $this->_age = $age;
    }

}