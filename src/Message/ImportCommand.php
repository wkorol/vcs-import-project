<?php

declare(strict_types=1);
namespace App\Message;

abstract class ImportCommand
{
    public function __construct(public readonly string $orgName)
    {

    }

    public function getOrgName(): string
    {
        return $this->orgName;
    }
}



