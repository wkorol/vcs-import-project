<?php

declare(strict_types=1);

namespace App\Message;

use App\Command\ImportCommand;
use App\Command\ProviderNotFound;


class ImportCommandCreator
{
    public function create(string $username, string $provider)
    {
        if ($provider === 'github')
        {
            return new GithubImportCommand($username);
        }
        if($provider === 'bitbucket')
        {
            return new BitbucketImportCommand($username);
        }
        throw new ProviderNotFound($provider);
    }
}