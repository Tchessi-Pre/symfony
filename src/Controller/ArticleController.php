<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Flasher\Prime\FlasherInterface;

class ArticleController extends AbstractController
{
    #[Route('/articles', name: 'app_article')]
    public function index(): Response
    {
        return $this->render('article/index.html.twig');
    }

    #[Route('/articles/create-article', name: 'app_article')]
    public function create(Request $request, ManagerRegistry $doctrine, FlasherInterface $flasher, SluggerInterface $slugger): Response
    {

        $entityManager = $doctrine->getManager();
        $article = new Article;

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->setUser($this->getUser());
            $article->setSlug(strtolower($slugger->slug($article->getTitle())));
            $entityManager->persist($article);
            $entityManager->flush();
            $flasher->addSuccess('Bravo vous avez ajouté un article');
        }

        return $this->render('article/create.html.twig', [

            'FormArticle' => $form->createView()
        ]);
    }
}
