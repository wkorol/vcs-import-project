<?php
declare(strict_types=1);

namespace App\MessageHandler;
use App\Message\BitbucketImportCommand;
use App\Services\BitbucketService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class BitbucketImportCommandHandler implements MessageHandlerInterface
{
    private BitbucketService $bitbucketService;

    public function __construct(BitbucketService $bitbucketService)
    {
        $this->bitbucketService = $bitbucketService;
    }

    public function __invoke(BitbucketImportCommand $command)
    {
        $this->bitbucketService->importToDb($command->getOrgName());
    }
}

