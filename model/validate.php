<?php

class Validate
{
    private $_dataLayer;

    /**
     * Validate constructor.
     * @param $_dataLayer
     */
    public function __construct()
    {
        $this->_dataLayer = new DataLayer();
    }


}