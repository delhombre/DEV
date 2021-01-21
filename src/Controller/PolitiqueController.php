<?php

namespace App\Controller;

use App\Entity\Politique;
use App\Repository\PolitiqueRepository;
use App\Service\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PolitiqueController extends AbstractController
{
    /**
     * @Route("/politiques", name="politique")
     */
    public function index(PolitiqueRepository $politiqueRepository, Paginator $paginator): Response
    {
        $politiques = $politiqueRepository->getPaginator($paginator->getOffset());

        return $this->render('politique/index.html.twig', [
            'politiques' => $politiques,
            'previous' => $paginator->previous($politiqueRepository::PAGINATOR_PER_PAGE),
            'next' => $paginator->next($politiques, $politiqueRepository::PAGINATOR_PER_PAGE),
            "current_menu" => "politique"
        ]);
    }

    /**
     * @Route("/politiques/{id}", name="politique_show")
     */
    public function show(Politique $politique)
    {
        return $this->render('politique/show.html.twig', [
            "politique" => $politique
        ]);
    }
}
