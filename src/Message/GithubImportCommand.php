<?php

declare(strict_types=1);

namespace App\Message;

class GithubImportCommand
{
    private string $orgName;

    public function __construct(string $orgName)
    {
        $this->orgName = $orgName;
    }
    public function getOrgName(): string
    {
        return $this->orgName;
    }
}