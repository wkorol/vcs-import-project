<?php

namespace App\Controller;

use App\Repository\OrgRepository;
use App\Repository\RepoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    private $r;
    
    public function __construct(RepoRepository $r) {
        $this->r = $r;

    }

    #[Route('/api', name: 'api')]
    public function index() : Response 
    {   
        $data = json_encode($this->r->findAll(), JSON_PRETTY_PRINT);
        return new Response("<pre>$data</pre>");
    }
}
