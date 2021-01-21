<?php

namespace App\Controller;

use App\Entity\News;
use App\Repository\CultureRepository;
use App\Repository\EconomieRepository;
use App\Repository\EnvironnementRepository;
use App\Repository\NewsRepository;
use App\Repository\PolitiqueRepository;
use App\Repository\SanteRepository;
use App\Repository\SportRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(NewsRepository $newsRepository, EconomieRepository $economieRepository, CultureRepository $cultureRepository, PolitiqueRepository $politiqueRepository, SportRepository $sportRepository, SanteRepository $santeRepository, EnvironnementRepository $environnementRepository): Response
    {
        return $this->render('home/index.html.twig', [
            "news" => $newsRepository->findBySomeLimit(9),
            "economies" => $economieRepository->findBySomeLimit(6),
            "cultures" => $cultureRepository->findBy([], ["id" => "DESC"], 6),
            "politiques" => $politiqueRepository->findBy([], ["id" => "DESC"], 9),
            "sports" => $sportRepository->findBy([], ["id" => "DESC"], 6),
            "santes" => $santeRepository->findBy([], ["id" => "DESC"], 6),
            "environnements" => $environnementRepository->findBy([], ["id" => "DESC"], 6),
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
