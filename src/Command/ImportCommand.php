<?php
namespace App\Command;


//use App\Service\SymfonyDocs;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;


class GitCommand extends Command {
    protected static $defaultName = 'import:repository';

    /*private $symfonyDocs;
    public function __construct(SymfonyDocs $symfonyDocs)
    {
        $this->symfonyDocs = $symfonyDocs;

        parent::__construct();
    }*/



    protected function configure()
    {

        $this->addArgument('username', InputArgument::REQUIRED, 'Organization Name');
        $this->addArgument('provider', InputArgument::REQUIRED, 'Provider Name');

        parent::configure(); // TODO: Change the autogenerated stub
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        //$username = $input->getArgument('username');
        //$url = 'https://api.github.com/users/' . $username;

        //$provider = $input->getArgument('provider');
        //$test = $this->symfonyDocs->fetchGitHubInformation($url);

        //$output->writeln($test);



        return Command::SUCCESS;
    }

}