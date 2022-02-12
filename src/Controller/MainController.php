<?php

namespace App\Controller;

use App\Entity\Repo;
use App\Repository\RepoRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{
    private $doctrine;
    private $org;

    public function __construct(ManagerRegistry $doctrine, RepoRepository $org) {
        $this->doctrine = $doctrine;
        $this->org = $org;

    }



    #[Route('/github', name: 'github')]
    public function githubList(PaginatorInterface $paginator, Request $request) {
        $entityManager = $this->doctrine->getManager();
        $githubRepository = $entityManager->getRepository(Repo::class)->findOfType('github');
        
        
        
        return $this->render('main/index.html.twig', [
            'type' => 'github',
            'repos' =>  $paginator->paginate($githubRepository, $request->query->getInt('page', 1),10),
            
        ]);
    }
    #[Route('/bitbucket', name: 'bitbucket')]
    public function bitbucketList(PaginatorInterface $paginator, Request $request) {
        $entityManager = $this->doctrine->getManager();
        $bitbucketRepository = $entityManager->getRepository(Repo::class)->findOfType('bitbucket');
        
        
        
        return $this->render('main/index.html.twig', [
            'type' => 'Bitbucket',
            'repos' => $paginator->paginate($bitbucketRepository, $request->query->getInt('page', 1),10),
            

            
        ]);
    }

    
    

}
