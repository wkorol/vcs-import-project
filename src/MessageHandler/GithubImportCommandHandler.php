<?php
declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\ImportCommandCreator;
use App\Services\GithubService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GithubImportCommandHandler implements MessageHandlerInterface {


    public function __invoke(ImportCommandCreator $message) {

    }

}


