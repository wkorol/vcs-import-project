<?php

declare(strict_types=1);

namespace App\Message;

class GithubImportCommandFactory implements ImportCommandFactory
{
    public function create(string $orgName, string $provider): ImportCommand
    {
        return new GithubImportCommand($orgName);
    }
}


