<?php
declare(strict_types=1);

namespace App\MessageHandler;
use App\Message\ImportCommandCreator;
use App\Services\BitbucketService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class BitbucketImportCommandHandler implements MessageHandlerInterface {

    public function __invoke(ImportCommandCreator $message) {

    }
}

