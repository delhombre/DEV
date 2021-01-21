<?php

namespace App\Controller;

use App\Entity\Sante;
use App\Repository\SanteRepository;
use App\Service\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SanteController extends AbstractController
{
    /**
     * @Route("/sante", name="sante")
     */
    public function index(SanteRepository $santeRepository, Paginator $paginator): Response
    {
        $santes = $santeRepository->getPaginator($paginator->getOffset());

        return $this->render('sante/index.html.twig', [
            'santes' => $santes,
            'previous' => $paginator->previous($santeRepository::PAGINATOR_PER_PAGE),
            'next' => $paginator->next($santes, $santeRepository::PAGINATOR_PER_PAGE),
            "current_menu" => "sante"
        ]);
    }

    /**
     * @Route("/santes/{id}", name="sante_show")
     */
    public function show(Sante $sante)
    {
        return $this->render('sante/show.html.twig', [
            "sante" => $sante
        ]);
    }
}
