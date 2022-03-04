<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\GithubImportCommand;
use App\Services\GithubService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GithubImportCommandHandler implements MessageHandlerInterface
{
    private GithubService $githubService;

    public function __construct(GithubService $githubService)
    {
        $this->githubService = $githubService;
    }
    public function __invoke(GithubImportCommand $command)
    {
        $this->githubService->importToDb($command->getOrgName());
    }

}


