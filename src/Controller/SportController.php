<?php

namespace App\Controller;

use App\Entity\Sport;
use App\Repository\SportRepository;
use App\Service\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SportController extends AbstractController
{
    /**
     * @Route("/sports", name="sport")
     */
    public function index(SportRepository $sportRepository, Paginator $paginator): Response
    {
        $sports = $sportRepository->getPaginator($paginator->getOffset());

        return $this->render('sport/index.html.twig', [
            'sports' => $sports,
            'previous' => $paginator->previous($sportRepository::PAGINATOR_PER_PAGE),
            'next' => $paginator->next($sports, $sportRepository::PAGINATOR_PER_PAGE),
            "current_menu" => "sport"
        ]);
    }

    /**
     * @Route("/sports/{id}", name="sport_show")
     */
    public function show(Sport $sport)
    {
        return $this->render('sport/show.html.twig', [
            "sport" => $sport
        ]);
    }
}
