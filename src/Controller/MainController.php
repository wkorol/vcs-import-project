<?php

namespace App\Controller;

use App\Repository\OrgRepository;
use App\Repository\RepoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main')]
    public function index(RepoRepository $r): Response
    {

        $repos = $r->showAllRepos();

        return new Response($this->renderView('main/index.html.twig', array(
            'repos' => $repos
        )));
    }
}
