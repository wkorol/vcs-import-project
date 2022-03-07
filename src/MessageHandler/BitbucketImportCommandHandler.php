<?php
declare(strict_types=1);

namespace App\MessageHandler;
use App\Entity\BitBucket;
use App\Entity\Org;
use App\Entity\Repo;
use App\Message\BitbucketImportCommand;
use App\Repository\RepoRepository;
use App\Services\DBService;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BitbucketImportCommandHandler extends DBService implements MessageHandlerInterface
{
    private $bitbucketHeaders;
    private $bitbucketapiurl;
    public $authenticatedApiLimiter;
    public $anonymousApiLimiter;
    private Org $organisation;
    private ManagerRegistry $doctrine;
    public HttpClientInterface $client;
    private RepoRepository $repoRepository;

    public function __construct(ParameterBagInterface $params, HttpClientInterface $client, ManagerRegistry $doctrine, RateLimiterFactory $authenticatedApiLimiter, RateLimiterFactory $anonymousApiLimiter, RepoRepository $repoRepository)
    {
        $this->authenticatedApiLimiter = $authenticatedApiLimiter;
        $this->anonymousApiLimiter = $anonymousApiLimiter;
        $this->client = $client;
        $this->repoRepository = $repoRepository;
        $this->doctrine = $doctrine;
        $this->organisation = new Org();
        $this->bitbucketapiurl = $params->get('bitbucketapiurl');
        $this->bitbucketHeaders = [
            'Authorization' => ''
        ];

    }

    public function __invoke(BitbucketImportCommand $command)
    {
        $this->importToDb($command->getOrgName());
    }

    public function importToDb($orgName): bool
    {
        $entityManager = $this->doctrine->getManager();
        if ($this->repoRepository->findOrgWithProvider('bitbucket', $orgName))
        {
            $entityManager->getRepository(Repo::class)->deleteOfType('bitbucket');
        }
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

