<?php

namespace App\Controller;

use App\Entity\Culture;
use App\Entity\Economie;
use App\Entity\Environnement;
use App\Entity\News;
use App\Entity\Politique;
use App\Entity\Sante;
use App\Entity\Sport;
use App\Entity\User;
use App\Form\CultureType;
use App\Form\EconomieType;
use App\Form\NewsType;
use App\Form\PolitiqueType;
use App\Form\SanteType;
use App\Form\UserType;
use App\Repository\CultureRepository;
use App\Repository\EconomieRepository;
use App\Repository\EnvironnementRepository;
use App\Repository\NewsRepository;
use App\Repository\PolitiqueRepository;
use App\Repository\SanteRepository;
use App\Repository\SportRepository;
use App\Service\Paginator;
use App\Service\Uploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    protected $paginator;
    protected $request;
    protected $em;
    protected $uploader;

    public function __construct(Paginator $paginator, RequestStack $requestStack, EntityManagerInterface $em, Uploader $uploader)
    {
        $this->paginator = $paginator;
        $this->request = $requestStack->getCurrentRequest();
        $this->em = $em;
        $this->uploader = $uploader;
    }

    /**
     * @Route("/admin", name="admin_news")
     */
    public function news(NewsRepository $newsRepository): Response
    {
        $paginator = $newsRepository->getPaginator($this->paginator->getOffset());

        return $this->render('admin/news.html.twig', [
            'news' => $paginator,
            'previous' => $this->paginator->previous($newsRepository::PAGINATOR_PER_PAGE),
            'next' => $this->paginator->next($paginator, $newsRepository::PAGINATOR_PER_PAGE)
        ]);
    }

    /**
     * @Route("/admin/news/new", name="admin_create_news")
     * @Route("/admin/news/edit/{id}", name="admin_edit_news")
     */
    public function newsForm(News $news = null, string $newsImageDir)
    {
        if (!$news) {
            $news = new News();
        }

        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $form['image']->getData()) {
                $filename = $this->uploader->upload($image, $newsImageDir);
                $news->setImage($filename);
            }

            if (!$news->getId()) {
                $news->setCreatedAt(new \DateTime());
            } else {
                $news->setUpdatedAt(new \DateTime());
            }

            $this->em->persist($news);
            $this->em->flush();

            if (!$news->getId()) {
                $this->addFlash('success', 'Bien crée');
                return $this->redirectToRoute('admin_news');
            } else {
                $this->addFlash('success', 'Bien modifié');
                return $this->redirectToRoute('admin_news');
            }
        }

        return $this->render('admin/newsform.html.twig', [
            "form" => $form->createView(),
            "editMode" => $news->getId() !== null
        ]);
    }

    /**
     * @Route("/admin/news/{id}/delete", name="admin_delete_news")
     */
    public function deleteNews(News $news)
    {
        $this->em->remove($news);
        $this->em->flush();

        return $this->redirectToRoute("admin_news");
    }

    /**
     * @Route("/admin/cultures", name="admin_cultures")
     */
    public function cultures(CultureRepository $cultureRepository)
    {
        $paginator = $cultureRepository->getPaginator($this->paginator->getOffset());

        return $this->render('admin/cultures.html.twig', [
            'cultures' => $paginator,
            'previous' => $this->paginator->previous($cultureRepository::PAGINATOR_PER_PAGE),
            'next' => $this->paginator->next($paginator, $cultureRepository::PAGINATOR_PER_PAGE)
        ]);
    }

    /**
     * @Route("/admin/culture/new", name="admin_create_culture")
     * @Route("/admin/culture/edit/{id}", name="admin_edit_culture")
     */
    public function cultureForm(Culture $culture = null, string $cultureImageDir)
    {
        if (!$culture) {
            $culture = new Culture();
        }

        $form = $this->createForm(CultureType::class, $culture);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $form['image']->getData()) {
                $filename = $this->uploader->upload($image, $cultureImageDir);
                $culture->setImage($filename);
            }

            if (!$culture->getId()) {
                $culture->setCreatedAt(new \DateTime());
            } else {
                $culture->setUpdatedAt(new \DateTime());
            }

            $this->em->persist($culture);
            $this->em->flush();

            if (!$culture->getId()) {
                $this->addFlash('success', 'Bien crée');
                return $this->redirectToRoute('admin_cultures');
            } else {
                $this->addFlash('success', 'Bien modifié');
                return $this->redirectToRoute('admin_cultures');
            }
        }

        return $this->render('admin/cultureform.html.twig', [
            "form" => $form->createView(),
            "editMode" => $culture->getId() !== null
        ]);
    }

    /**
     * @Route("/admin/culture/{id}/delete", name="admin_delete_culture")
     */
    public function deleteCulture(Culture $culture)
    {
        $this->em->remove($culture);
        $this->em->flush();

        return $this->redirectToRoute("admin_cultures");
    }

    /**
     * @Route("/admin/economies", name="admin_economies")
     */
    public function economies(EconomieRepository $economieRepository)
    {
        $paginator = $economieRepository->getPaginator($this->paginator->getOffset());

        return $this->render('admin/economies.html.twig', [
            'economies' => $paginator,
            'previous' => $this->paginator->previous($economieRepository::PAGINATOR_PER_PAGE),
            'next' => $this->paginator->next($paginator, $economieRepository::PAGINATOR_PER_PAGE)
        ]);
    }

    /**
     * @Route("/admin/economie/new", name="admin_create_economie")
     * @Route("/admin/economie/edit/{id}", name="admin_edit_economie")
     */
    public function economieForm(Economie $economie = null, string $economieImageDir)
    {
        if (!$economie) {
            $economie = new Economie();
        }

        $form = $this->createForm(EconomieType::class, $economie);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $form['image']->getData()) {
                $filename = $this->uploader->upload($image, $economieImageDir);
                $economie->setImage($filename);
            }

            if (!$economie->getId()) {
                $economie->setCreatedAt(new \DateTime());
            } else {
                $economie->setUpdatedAt(new \DateTime());
            }

            $this->em->persist($economie);
            $this->em->flush();

            if (!$economie->getId()) {
                $this->addFlash('success', 'Bien crée');
                return $this->redirectToRoute('admin_economies');
            } else {
                $this->addFlash('success', 'Bien modifié');
                return $this->redirectToRoute('admin_economies');
            }
        }

        return $this->render('admin/economieform.html.twig', [
            "form" => $form->createView(),
            "editMode" => $economie->getId() !== null
        ]);
    }

    /**
     * @Route("/admin/economie/{id}/delete", name="admin_delete_economie")
     */
    public function deleteEconomie(Economie $economie)
    {
        $this->em->remove($economie);
        $this->em->flush();

        return $this->redirectToRoute("admin_economies");
    }

    /**
     * @Route("/admin/environnements", name="admin_environnements")
     */
    public function environnements(EnvironnementRepository $environnementRepository)
    {
        $paginator = $environnementRepository->getPaginator($this->paginator->getOffset());

        return $this->render("admin/environnements.html.twig", [
            'environnements' => $paginator,
            'previous' => $this->paginator->previous($environnementRepository::PAGINATOR_PER_PAGE),
            'next' => $this->paginator->next($paginator, $environnementRepository::PAGINATOR_PER_PAGE)
        ]);
    }

    /**
     * @Route("/admin/environnement/new", name="admin_create_environnement")
     * @Route("/admin/environnement/edit/{id}", name="admin_edit_environnement")
     */
    public function environnementForm(Environnement $environnement = null, string $environnementImageDir)
    {
        if (!$environnement) {
            $environnement = new Environnement();
        }

        $form = $this->createForm(Environnement::class, $environnement);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $form['image']->getData()) {
                $filename = $this->uploader->upload($image, $environnementImageDir);
                $environnement->setImage($filename);
            }

            if (!$environnement->getId()) {
                $environnement->setCreatedAt(new \DateTime());
            } else {
                $environnement->setUpdatedAt(new \DateTime());
            }

            $this->em->persist($environnement);
            $this->em->flush();

            if (!$environnement->getId()) {
                $this->addFlash('success', 'Bien crée');
                return $this->redirectToRoute('admin_environnements');
            } else {
                $this->addFlash('success', 'Bien modifié');
                return $this->redirectToRoute('admin_environnements');
            }
        }

        return $this->render('admin/environnementform.html.twig', [
            "form" => $form->createView(),
            "editMode" => $environnement->getId() !== null
        ]);
    }

    /**
     * @Route("/admin/environnement/{id}/delete", name="admin_delete_environnement")
     */
    public function deleteEnvironnement(Environnement $environnement)
    {
        $this->em->remove($environnement);
        $this->em->flush();

        return $this->redirectToRoute("admin_environnements");
    }

    /**
     * @Route("/admin/politiques", name="admin_politiques")
     */
    public function politiques(PolitiqueRepository $politiqueRepository)
    {
        $paginator = $politiqueRepository->getPaginator($this->paginator->getOffset());

        return $this->render("admin/politiques.html.twig", [
            'politiques' => $paginator,
            'previous' => $this->paginator->previous($politiqueRepository::PAGINATOR_PER_PAGE),
            'next' => $this->paginator->next($paginator, $politiqueRepository::PAGINATOR_PER_PAGE)
        ]);
    }

    /**
     * @Route("/admin/politique/new", name="admin_create_politique")
     * @Route("/admin/politique/edit/{id}", name="admin_edit_politique")
     */
    public function politiqueForm(Politique $politique = null, string $politiqueImageDir)
    {
        if (!$politique) {
            $politique = new Politique();
        }

        $form = $this->createForm(PolitiqueType::class, $politique);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $form['image']->getData()) {
                $filename = $this->uploader->upload($image, $politiqueImageDir);
                $politique->setImage($filename);
            }

            if (!$politique->getId()) {
                $politique->setCreatedAt(new \DateTime());
            } else {
                $politique->setUpdatedAt(new \DateTime());
            }

            $this->em->persist($politique);
            $this->em->flush();

            if (!$politique->getId()) {
                $this->addFlash('success', 'Bien crée');
                return $this->redirectToRoute('admin_politiques');
            } else {
                $this->addFlash('success', 'Bien modifié');
                return $this->redirectToRoute('admin_politiques');
            }
        }

        return $this->render('admin/politiqueform.html.twig', [
            "form" => $form->createView(),
            "editMode" => $politique->getId() !== null
        ]);
    }

    /**
     * @Route("/admin/politique/{id}/delete", name="admin_delete_politique")
     */
    public function deletePolitique(Politique $politique)
    {
        $this->em->remove($politique);
        $this->em->flush();

        return $this->redirectToRoute("admin_politiques");
    }

    /**
     * @Route("/admin/santes", name="admin_santes")
     */
    public function santes(SanteRepository $santeRepository)
    {
        $paginator = $santeRepository->getPaginator($this->paginator->getOffset());

        return $this->render("admin/santes.html.twig", [
            'santes' => $paginator,
            'previous' => $this->paginator->previous($santeRepository::PAGINATOR_PER_PAGE),
            'next' => $this->paginator->next($paginator, $santeRepository::PAGINATOR_PER_PAGE)
        ]);
    }

    /**
     * @Route("/admin/sante/new", name="admin_create_sante")
     * @Route("/admin/sante/edit/{id}", name="admin_edit_sante")
     */
    public function santeForm(Sante $sante = null, string $santeImageDir)
    {
        if (!$sante) {
            $sante = new Sante();
        }

        $form = $this->createForm(SanteType::class, $sante);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $form['image']->getData()) {
                $filename = $this->uploader->upload($image, $santeImageDir);
                $sante->setImage($filename);
            }

            if (!$sante->getId()) {
                $sante->setCreatedAt(new \DateTime());
            } else {
                $sante->setUpdatedAt(new \DateTime());
            }

            $this->em->persist($sante);
            $this->em->flush();

            if (!$sante->getId()) {
                $this->addFlash('success', 'Bien crée');
                return $this->redirectToRoute('admin_santes');
            } else {
                $this->addFlash('success', 'Bien modifié');
                return $this->redirectToRoute('admin_santes');
            }
        }

        return $this->render('admin/santeform.html.twig', [
            "form" => $form->createView(),
            "editMode" => $sante->getId() !== null
        ]);
    }

    /**
     * @Route("/admin/sante/{id}/delete", name="admin_delete_sante")
     */
    public function deleteSante(Sante $sante)
    {
        $this->em->remove($sante);
        $this->em->flush();

        return $this->redirectToRoute("admin_santes");
    }

    /**
     * @Route("/admin/sports", name="admin_sports")
     */
    public function sports(SportRepository $sportRepository)
    {
        $paginator = $sportRepository->getPaginator($this->paginator->getOffset());

        return $this->render("admin/sports.html.twig", [
            'sports' => $paginator,
            'previous' => $this->paginator->previous($sportRepository::PAGINATOR_PER_PAGE),
            'next' => $this->paginator->next($paginator, $sportRepository::PAGINATOR_PER_PAGE)
        ]);
    }

    /**
     * @Route("/admin/sport/new", name="admin_create_sport")
     * @Route("/admin/sport/edit/{id}", name="admin_edit_sport")
     */
    public function sportForm(Sport $sport = null, string $sportImageDir)
    {
        if (!$sport) {
            $sport = new Sante();
        }

        $form = $this->createForm(SanteType::class, $sport);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $form['image']->getData()) {
                $filename = $this->uploader->upload($image, $sportImageDir);
                $sport->setImage($filename);
            }

            if (!$sport->getId()) {
                $sport->setCreatedAt(new \DateTime());
            } else {
                $sport->setUpdatedAt(new \DateTime());
            }

            $this->em->persist($sport);
            $this->em->flush();

            if (!$sport->getId()) {
                $this->addFlash('success', 'Bien crée');
                return $this->redirectToRoute('admin_sports');
            } else {
                $this->addFlash('success', 'Bien modifié');
                return $this->redirectToRoute('admin_sports');
            }
        }

        return $this->render('admin/sportform.html.twig', [
            "form" => $form->createView(),
            "editMode" => $sport->getId() !== null
        ]);
    }

    /**
     * @Route("/admin/sport/{id}/delete", name="admin_delete_sport")
     */
    public function deleteSport(Sport $sport)
    {
        $this->em->remove($sport);
        $this->em->flush();

        return $this->redirectToRoute("admin_sports");
    }

    /**
     * @Route("/admin/changer-le-mot-de-passe", name="admin_change_password")
     */
    public function changePassword(UserPasswordEncoderInterface $encoder)
    {
        /**
         * @var User
         */
        $user = $this->getUser();

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($this->request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $this->request->request->all()["user"]["password"];
            $user->setPassword($encoder->encodePassword($user, $plainPassword));

            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash("passwordchange", "Votre mot de passe a été mis à jour");
            return $this->redirectToRoute("admin_change_password");
        }

        return $this->render('admin/change_password.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/encode", name="admin_encode")
     */
    public function encode(UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        dd($encoder->encodePassword($user, "password7894561"));
    }
}
