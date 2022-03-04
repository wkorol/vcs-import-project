<?php

namespace App\Command;

class ProviderNotFound extends \InvalidArgumentException
{

    public function __construct($provider){
        parent::__construct($provider. 'as a provider has not been found');
    }


}