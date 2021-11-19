<?php

class Advisor
{
    // table fields
    public $name;
    public $password;
    public $email;
    public $availability;
    // constructor set default value
    function __construct()
    {
        $availability = 0;
    }
}
