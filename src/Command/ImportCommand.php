<?php
namespace App\Command;

use App\Repository\OrgRepository;
use App\Services\BitbucketService;
use App\Services\GithubService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ImportCommand extends Command {
    protected static $defaultName = 'import:repository';

    private $githubService;
    private $orgRepository;
    private $bitbucketService;
    private $dbService;
    private $providers;
    
    public function __construct(GithubService $githubService, OrgRepository $orgRepository, bitbucketService $bitbucketService, ParameterBagInterface $params)
    {
        $this->params = $params;
        $this->orgRepository = $orgRepository;
        $this->githubService = $githubService;
        $this->bitbucketService = $bitbucketService;
        $this->providers = $params->get('providers');
        

    
        parent::__construct();
    }

    public function checkProviderExistance($providerName) : bool {
        if(in_array(strtolower($providerName), $this->providers)) {
            return true;
        }
        return false;
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
        
        if($this->checkProviderExistance($provider)) {
            switch(strtolower($provider)) {
                case 'github':
                    $this->githubService->importToDb($username);
                    break;
                case 'bitbucket':
                    $this->bitbucketService->importToDb($username);
                    break;
            }

            $output->writeln('Successfully imported ' . $username . ' into the ' . $provider . ' repository.');
            return Command::SUCCESS;
        }
            $output->writeln($provider . ' is not implemented yet.');
            return Command::FAILURE;
        

        
    }
    

}