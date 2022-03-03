<?php
declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\ImportCommandCreator;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class GithubImportCommandHandler implements MessageHandlerInterface {

    public function __construct() {

    }
    public function __invoke() {
        //test//
    }

}



?>