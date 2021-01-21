<?php

namespace App\Controller;

use App\Entity\Economie;
use App\Repository\EconomieRepository;
use App\Service\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EconomieController extends AbstractController
{
    /**
     * @Route("/economies", name="economie")
     */
    public function index(EconomieRepository $economieRepository, Paginator $paginator): Response
    {
        $economies = $economieRepository->getPaginator($paginator->getOffset());
        return $this->render('economie/index.html.twig', [
            'economies' => $economies,
            'previous' => $paginator->previous($economieRepository::PAGINATOR_PER_PAGE),
            'next' => $paginator->next($economies, $economieRepository::PAGINATOR_PER_PAGE),
            "current_menu" => "economie"
        ]);
    }

    /**
     * @Route("/economies/{id}", name="economie_show")
     */
    public function show(Economie $economie)
    {
        return $this->render('economie/show.html.twig', [
            "economie" => $economie
        ]);
    }
}
