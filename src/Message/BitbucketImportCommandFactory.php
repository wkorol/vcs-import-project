<?php

declare(strict_types=1);

namespace App\Message;

class BitbucketImportCommandFactory implements ImportCommandFactory
{
    public function create(string $orgName, string $provider): ImportCommand
    {
        return new BitbucketImportCommand($orgName);
    }
}

