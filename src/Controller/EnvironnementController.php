<?php

namespace App\Controller;

use App\Entity\Environnement;
use App\Repository\EnvironnementRepository;
use App\Service\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EnvironnementController extends AbstractController
{
    /**
     * @Route("/environnements", name="environnement")
     */
    public function index(EnvironnementRepository $environnementRepository, Paginator $paginator): Response
    {
        $environnements = $environnementRepository->getPaginator($paginator->getOffset());

        return $this->render('environnement/index.html.twig', [
            'environnements' => $environnements,
            'previous' => $paginator->previous($environnementRepository::PAGINATOR_PER_PAGE),
            'next' => $paginator->next($environnements, $environnementRepository::PAGINATOR_PER_PAGE),
            "current_menu" => "environnement"
        ]);
    }

    /**
     * @Route("/environnements/{id}", name="environnement_show")
     */
    public function show(Environnement $environnement)
    {
        return $this->render('environnement/show.html.twig', [
            "environnements" => $environnement
        ]);
    }
}
