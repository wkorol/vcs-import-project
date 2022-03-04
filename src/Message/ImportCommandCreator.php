<?php

declare(strict_types=1);

namespace App\Message;

use App\Command\ProviderNotFound;


class ImportCommandCreator
{
    public function create(string $orgName, string $provider)
    {
        if ($provider === 'github')
        {
            return new GithubImportCommand($orgName);
        }
        if($provider === 'bitbucket')
        {
            return new BitbucketImportCommand($orgName);
        }
        throw new ProviderNotFound($provider);
    }
}