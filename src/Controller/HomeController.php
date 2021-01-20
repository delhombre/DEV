<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_index")
     */
    public function index(NewsRepository $newsRepository): Response
    {
        return $this->render('home/index.html.twig', [
            "news" => $newsRepository->findBySomeLimit(6)
        ]);
    }
}
