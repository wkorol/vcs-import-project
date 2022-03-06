<?php

declare(strict_types=1);

namespace App\Message;

interface ImportCommandFactory
{
    public function create(string $orgName, string $provider): ImportCommand;
}