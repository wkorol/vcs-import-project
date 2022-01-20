<?php

namespace App\Controller;

use App\Repository\RepoRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
//

}
