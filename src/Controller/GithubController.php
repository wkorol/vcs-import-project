<?php

namespace App\Controller;


use App\Entity\Org;
use App\Entity\Repo;
use DateTime;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubController extends AbstractController

{
    private $client;
    private $doctrine;

    public function __construct(HttpClientInterface $client, ManagerRegistry $doctrine)
    {
        $this->client = $client;
        $this->doctrine = $doctrine;
    }

    public function checkTokenExists() : Bool {
        if($this->getParameter('githubtoken') == '')
            return false;
        else return true;
    }

    public function setTrustPoints(int $commits_count, int $pullr_count, int $star_count) : Float {
        return $commits_count + $pullr_count*1.2 + $star_count *2;
    }


    public function fetchData($url): array
    {

        $response = $this->client->request('GET', $url, [
            'headers' => [
                'Authorization' => 'token ' . $this->getParameter('githubtoken'),
                'Content-type' =>  'application/json',
                'User-Agent' =>  'vcs-import-project'
            ],
        ]);
        
        $rep = $response->getContent();
        $rep = $response->toArray();

        return $rep;
    }

            
    /**
     * @throws \Exception
     */
    public function importToDb($username, $provider) : Bool {

        $entityManager = $this->doctrine->getManager();
        $url = 'https://api.github.com/users/' . $username . '/repos';

        $listRepos = [];
        $i = 0;

        $rep = $this->fetchData($url);
        if (empty($rep))
            return false;

            $organisation = new Org();
            $organisation->setName($username);
            $organisation->setProvider($provider);
            $organisation->setLink($rep[0]['owner']['html_url']);


        foreach ($rep as $r) {
            $listRepos[$i] = new Repo();
            $commitsUrl = $r['url'] . '/commits';
            $pullsUrl = $r['url'] . '/pulls';
            $listRepos[$i]->setOrg($organisation);
            $listRepos[$i]->setName($r['name']);
            $listRepos[$i]->setLink($r['html_url']);
            $listRepos[$i]->setCreateDate(new DateTime(date('Y-m-d', strtotime($r['created_at']))));
            $listRepos[$i]->setCommits(sizeof($this->fetchData($commitsUrl)));
            $listRepos[$i]->setPulls(sizeof($this->fetchData($pullsUrl)));
            $listRepos[$i]->setStars($r['stargazers_count']);
            $entityManager->persist($listRepos[$i]);
            $listRepos[$i]->setPoints($this->setTrustPoints($listRepos[$i]->getCommits(), $listRepos[$i]->getPulls(), $listRepos[$i]->getStars()));

            $i++;
        }


        $entityManager->persist($organisation);
        $entityManager->flush();

        return true;
    }
}
