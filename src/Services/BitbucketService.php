<?php
namespace App\Services;

use App\Entity\BitBucket;
use App\Entity\Org;
use App\Util\DBInterface;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BitbucketService extends DBService implements DBInterface {

    private $bitbucketHeaders;
    private $bitbucketapiurl;
    public $authenticatedApiLimiter;
    public $anonymousApiLimiter;
    
    public function __construct(ParameterBagInterface $params, HttpClientInterface $client, ManagerRegistry $doctrine, RateLimiterFactory $authenticatedApiLimiter, RateLimiterFactory $anonymousApiLimiter)
    {
        $this->authenticatedApiLimiter = $authenticatedApiLimiter;
        $this->anonymousApiLimiter = $anonymousApiLimiter;
        $this->client = $client;
        $this->doctrine = $doctrine;
        $this->organisation = new Org();
        $this->bitbucketapiurl = $params->get('bitbucketapiurl');
        $this->bitbucketHeaders = [
            'Authorization' => ''
        ];
        
    }

    /**
     * @throws \Exception
     */
    public function importToDb($orgName): bool
    {
        $entityManager = $this->doctrine->getManager();
        $url = $this->bitbucketapiurl . $orgName;
        $rep = $this->fetchData($url, $this->bitbucketHeaders); 
        $this->organisation->setName($orgName);

        foreach ($rep['values'] as $r) {
            $bitbucket = new BitBucket();
            $commitsUrl = $r['links']['commits']['href'];
            $pullsUrl = $r['links']['pullrequests']['href'];
            $commitsTemp = $this->fetchData($commitsUrl,$this->bitbucketHeaders);
            $pullsTemp = $this->fetchData($pullsUrl, $this->bitbucketHeaders);
            $bitbucket->setName($r['name']);
            $bitbucket->setCreateDate(new DateTime(date('Y-m-d', strtotime($r['created_on']))));
            $bitbucket->setLink($r['links']['html']['href']);
            $bitbucket->setPulls(sizeof($pullsTemp['values']));
            $bitbucket->setCommits(sizeof($commitsTemp['values']));
            $bitbucket->setOrg($this->organisation);
            $bitbucket->setPoints();
            $this->organisation->addRepo($bitbucket);
        }
        $entityManager->persist($this->organisation);
        $entityManager->flush();

        return true;
        
    }
    
}


?>