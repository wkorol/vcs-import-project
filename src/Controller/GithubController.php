<?php

namespace App\Controller;


use App\Entity\Org;
use App\Entity\Repo;
use DateTime;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class GithubController extends AbstractController

{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function setTrustPoints(int $commits_count, int $pullr_count, int $star_count) : Float {
        return $commits_count + $pullr_count*1.2 + $star_count *2;
    }


    public function fetchData($url): array
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json', 'User-Agent: vcs-import-project', 'Authorization: token ' . $this->getParameter('githubtoken')));
        $rep = json_decode(curl_exec($ch), true);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpcode == '404') {
            $rep = [];
        }
        curl_close($ch);


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
