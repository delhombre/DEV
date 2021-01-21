<?php

namespace App\Controller;

use App\Entity\News;
use App\Repository\EconomieRepository;
use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(NewsRepository $newsRepository, EconomieRepository $economieRepository): Response
    {
        return $this->render('home/index.html.twig', [
            "news" => $newsRepository->findBySomeLimit(9),
            "economies" => $economieRepository->findBySomeLimit(3),
            "current_menu" => "home"
        ]);
    }

    /**
     * @Route("/a-la-une/{id}", name="news_show")
     */
    public function newsShow(News $news)
    {
        return $this->render('home/news_show.html.twig', [
            "news" => $news
        ]);
    }
}
