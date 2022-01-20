<?php

namespace App\Controller;

use App\Repository\OrgRepository;
use App\Repository\RepoRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    private $r;
    public function __construct(RepoRepository $r) {
        $this->r = $r;
        $r->sortByPoints();


    }
    #[Route('/', name: 'main')]
    public function repoList(PaginatorInterface $paginator, Request $request) {
        $repository = $this->r->showAllRepos();
        return $this->render('main/index.html.twig', [
            'repos' =>  $paginator->paginate($repository, $request->query->getInt('page', 1),10)
        ]);
    }
//    public function index(): Response
//    {
//
//        $repos = $this->r->showAllRepos('r.create_date', 'ASC');
//        $test = '(b, a) => a.points <=> b.points';
//
//
//        return new Response($this->renderView('main/index.html.twig', array(
//            'repos' => $repos,
//            'test' => $test
//
//        )));
//    }

}
