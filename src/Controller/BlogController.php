<?php

namespace App\Controller;

use App\Entity\Article;
/* use App\Form\ArticleType; */
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager; /* use Doctrine\Common\Persistence\ObjectManager; */
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/blog/new', name: 'blog_create')]
    #[Route('/blog/{id}/edit', name: 'blog_edit')]
    public function form(Article $articles = null,Request $request, ObjectManager $manager){

            if(!$articles){
                $articles = new Article();
            }

            $form = $this->createForm(Article::class, $articles);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()){
                if(!$articles->getId()){

                    $articles->setCreatedeAt(new \DateTimeImmutable());

                }

                $manager->persist($articles);
                $manager->flush();

                return $this->$this->redirectToRoute('blog_show',['id'=>$articles->getId()]);
            }

        return $this->render('blog/create.html.twig',[
            'formArticle' => $form->createView(),
            'editMode' => $articles->getId() !==null
        ]);
    }
}
