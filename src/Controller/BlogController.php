<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class BlogController extends AbstractController
{

    #[Route('/', name: 'blog_home')]
    public function home(ManagerRegistry $doctrine): Response
    {

        $articles = $doctrine->getRepository(Article::class)
                             ->findAll();

        return $this->render('blog/home.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/blog/{id<\d+>}', name: 'blog_show')]
    public function show(ManagerRegistry $doctrine,$id): Response
    {
        $articles = $doctrine->getRepository(Article::class)
                             ->find($id);

        return $this->render('blog/show.html.twig',[
          'article'=>$articles
        ]);
    }

}
