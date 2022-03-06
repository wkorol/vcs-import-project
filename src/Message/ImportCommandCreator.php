<?php

declare(strict_types=1);

namespace App\Message;

use App\Command\ProviderNotFound;

class ImportCommandCreator implements ImportCommandFactory
{
    private array $factories = [];

    public function registerFactory(string $provider, ImportCommandFactory $factory): void
    {
        $this->factories[$provider] = $factory;
    }

    public function create(string $orgName, string $provider): ImportCommand
    {
        if (!isset($this->factories[$provider]))
        {
            throw new ProviderNotFound($provider);
        }

        return $this->factories[$provider]->create($orgName, $provider);
    }

}