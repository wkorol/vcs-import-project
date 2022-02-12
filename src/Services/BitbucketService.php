<?php
namespace App\Services;

use App\Entity\BitBucket;
use App\Entity\Org;
use App\Util\DBInterface;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BitbucketService extends DBService implements DBInterface {

    private $bitbucketHeaders;
    private $bitbuckettoken;
    private $bitbucketapiurl;
    
    public function __construct(ParameterBagInterface $params, HttpClientInterface $client, ManagerRegistry $doctrine)
    {
        $this->client = $client;
        $this->doctrine = $doctrine;
        $this->organisation = new Org();
        $this->bitbuckettoken = $params->get('bitbuckettoken');
        $this->bitbucketapiurl = $params->get('bitbucketapiurl');
        $this->bitbucketHeaders = [];
        
    }

    /**
     * @throws \Exception
     */
    public function importToDb($orgName): bool
    {
        $entityManager = $this->doctrine->getManager();
        $url = $this->bitbucketapiurl . $orgName;
        $rep = $this->fetchData($url, $this->bitbucketHeaders);
        if (empty($rep))
            return false;
        
        $this->organisation->setName($orgName);

        foreach ($rep['values'] as $r) {
            $commitsUrl = $r['links']['commits']['href'];
            $pullsUrl = $r['links']['pullrequests']['href'];
            $commitsTemp = $this->fetchData($commitsUrl,$this->bitbucketHeaders);
            $pullsTemp = $this->fetchData($pullsUrl, $this->bitbucketHeaders);
            $this->organisation->addRepo(new BitBucket(
                $r['name'],
                new DateTime(date('Y-m-d', strtotime($r['created_on']))),
                $r['links']['html']['href'],
                sizeof($pullsTemp['values']),
                sizeof($commitsTemp['values']),
                $this->organisation

            ));
        }
        $entityManager->persist($this->organisation);
        $entityManager->flush();

        return true;
    }
    
}


?>