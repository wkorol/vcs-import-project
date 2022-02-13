<?php
namespace App\Services;

use App\Entity\Github;
use App\Entity\Org;
use App\Util\DBInterface;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use function PHPUnit\Framework\isEmpty;

class GithubService extends DBService implements DBInterface {

    private $githubHeaders;
    private $githubtoken;
    private $githubapiurl;


    public function __construct(ParameterBagInterface $params, HttpClientInterface $client, ManagerRegistry $doctrine)
    {
        $this->client = $client;
        $this->doctrine = $doctrine;
        $this->organisation = new Org();
        $this->githubtoken = $params->get('githubtoken');
        $this->githubapiurl = $params->get('githubapiurl');
        $this->githubHeaders = array(
            'Authorization' => 'token ' . $this->githubtoken,
            'Content-Type' => 'application/json',
            'User-Agent' => 'vcs-import-project'
        
        );
        
    }
    
    public function importToDb($orgName): bool
    {
        $entityManager = $this->doctrine->getManager();
        $url = $this->githubapiurl . $orgName . '/repos';
        $rep = $this->fetchData($url, $this->githubHeaders);
        if(isEmpty($rep))
            return false;
        $this->organisation->setName($orgName);
        
            
        foreach ($rep as $r) {
                $commitsUrl = $r['url'] . '/commits';
                $pullsUrl = $r['url'] . '/pulls';
                $this->organisation->addRepo(new Github(
                    $r['name'],
                    new DateTime(date('Y-m-d', strtotime($r['created_at']))),
                    $r['html_url'],
                    sizeof($this->fetchData($pullsUrl, $this->githubHeaders)),
                    sizeof($this->fetchData($commitsUrl, $this->githubHeaders)),
                    $r['stargazers_count'],
                    $this->organisation
                ));
        }
        $entityManager->persist($this->organisation);
        $entityManager->flush();

        return true;
            
    }

}


?>