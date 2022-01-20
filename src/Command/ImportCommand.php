<?php
namespace App\Command;

use App\Controller\GithubController;


use App\Repository\OrgRepository;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;



class ImportCommand extends Command {
    protected static $defaultName = 'import:repository';

    private $github;
    private $org_repo;
    public function __construct(GithubController $githubController, OrgRepository $orgRepo)
    {
        $this->org_repo = $orgRepo;
        $this->github = $githubController;



        parent::__construct();
    }


    protected function configure()
    {
        $this->addArgument('username', InputArgument::REQUIRED, 'Organisation Name');
        $this->addArgument('provider', InputArgument::REQUIRED, 'Provider Name');

        parent::configure(); // TODO: Change the autogenerated stub
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $username = $input->getArgument('username');
        $provider = $input->getArgument('provider');
        if($this->github->checkTokenExists()) {


            if (!$this->org_repo->findOneBy(array('name' => $username))) {
                if($this->github->importToDb($username, $provider)) {
                    $output->writeln('Successfully inserted ' . $username . ' repositories to DB');
                } else {
                    $output->writeln('Check org name, it doesnt exists in Github API');
                }
            } else {
            $output->writeln('You have already imported this org repositories');
            }
            }
            else {
                $output->writeln('Please set GITHUB API Token in .env file');
            }


        return Command::SUCCESS;
    }

}