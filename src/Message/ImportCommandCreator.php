<?php

declare(strict_types=1);

namespace App\Message;

use App\MessageHandler\BitbucketImportCommandHandler;
use App\MessageHandler\GithubImportCommandHandler;

class ImportCommandCreator {
    public function create($username, $provider) {
        if ($provider == 'github') {
            return new GithubImportCommand($username);
        }
        if($provider == 'bitbucket') {
            return new BitbucketImportCommand($username);
        }
    }
}