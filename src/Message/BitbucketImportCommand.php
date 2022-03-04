<?php

declare(strict_types=1);

namespace App\Message;

class BitbucketImportCommand extends ImportCommand
{
    public function __construct(string $orgName)
    {
        parent::__construct($orgName);
    }
}