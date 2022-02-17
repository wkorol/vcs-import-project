<?php
namespace App\Services;

use App\Entity\Github;
use App\Entity\Org;
use App\Util\DBInterface;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Config\Framework\RateLimiterConfig;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use function PHPUnit\Framework\isEmpty;

class GithubService extends DBService implements DBInterface {

    private $githubHeaders;
    private $githubtoken;
    private $githubapiurl;
    public $client;
    public $authenticatedApiLimiter;
    public $anonymousApiLimiter;


    public function __construct(ParameterBagInterface $params, HttpClientInterface $client, ManagerRegistry $doctrine, RateLimiterFactory $authenticatedApiLimiter, RateLimiterFactory $anonymousApiLimiter)
    {
        $this->client = $client;
        $this->doctrine = $doctrine;
        $this->authenticatedApiLimiter = $authenticatedApiLimiter;
        $this->anonymousApiLimiter = $anonymousApiLimiter;
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
        $this->organisation->setName($orgName);
        
            
        foreach ($rep as $r) {
                $github = new Github();
                $commitsUrl = $r['url'] . '/commits';
                $pullsUrl = $r['url'] . '/pulls';
                $github->setName($r['name']);
                $github->setLink($r['html_url']);
                $github->setCreateDate(new DateTime(date('Y-m-d', strtotime($r['created_at']))));
                $github->setPulls(sizeof($this->fetchData($pullsUrl, $this->githubHeaders)));
                $github->setCommits(sizeof($this->fetchData($commitsUrl, $this->githubHeaders)));
                $github->setStars($r['stargazers_count']);
                $github->setOrg($this->organisation);
                $github->setPoints();
                $this->organisation->addRepo($github);
                
        }
        
        $entityManager->persist($this->organisation);
        $entityManager->flush();
        

        return true;
            
    }

}


?>