<?php

class History
{
    // table fields
    public $student_email;
    public $advisor_email;
    public $description;
    // constructor set default value
    function __construct()
    {
        $advisor_email = null;
    }
}
