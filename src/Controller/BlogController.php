<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index()
    {
        $posts = $this->getDoctrine()->getRepository(Article::class)->findBy([], ['createdAt'=>'DESC'], 5);
        return $this->render('blog/index.html.twig', [
            'auth' => 'admin',
            "posts" => $posts
        ]);
    }
}
