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
    public function index(OrgRepository $org, RepoRepository $repo): Response
    {

//        $test = $org->findOneBy(array('name' => 'wkorol'));
        $test2 = $repo->findByExampleField();

        return new Response($this->renderView('your/template.html.twig', array(
            // ...
//            'test' => $test,
            'test2' => $test2
        )));
    }
}
