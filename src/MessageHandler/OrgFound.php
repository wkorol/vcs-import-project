<?php

namespace App\MessageHandler;



class OrgFound extends \InvalidArgumentException
{
    public function __construct($orgName)
    {
        parent::__construct($orgName. ' is already found inserted into DB');
    }
}