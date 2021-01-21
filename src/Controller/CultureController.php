<?php

namespace App\Controller;

use App\Entity\Culture;
use App\Repository\CultureRepository;
use App\Service\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CultureController extends AbstractController
{
    /**
     * @Route("/cultures", name="culture")
     */
    public function index(CultureRepository $cultureRepository, Paginator $paginator): Response
    {
        $cultures = $cultureRepository->getPaginator($paginator->getOffset());

        return $this->render('culture/index.html.twig', [
            'cultures' => $cultures,
            'previous' => $paginator->previous($cultureRepository::PAGINATOR_PER_PAGE),
            'next' => $paginator->next($cultures, $cultureRepository::PAGINATOR_PER_PAGE),
            "current_menu" => "culture"
        ]);
    }

    /**
     * @Route("/cultures/{id}", name="culture_show")
     */
    public function show(Culture $culture)
    {
        return $this->render('culture/show.html.twig', [
            "culture" => $culture
        ]);
    }
}
