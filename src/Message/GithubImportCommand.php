<?php

declare(strict_types=1);

namespace App\Message;

class GithubImportCommand
{
    private string $username;

    public function __construct(string $username)
    {
        $this->username = $username;
    }
    public function getOrgName(): string
    {
        return $this->username;
    }
}