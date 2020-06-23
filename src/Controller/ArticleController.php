<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function blog()
    {
        $posts = $this->getDoctrine()->getRepository(Article::class)->findBy([], ['date'=>'DESC'], 5);
        return $this->render('article/blog.html.twig', [
            'auth' => 'admin',
            "posts" => $posts
        ]);
    }
}
