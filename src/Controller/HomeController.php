<?php

namespace App\Controller;

use App\Entity\Partner;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route(name="app_")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $partners = $this->getDoctrine()
            ->getRepository(Partner::class)
            ->findAll();

        return $this->render('home/index.html.twig', [
            'auth' => 'admin',
            'partners' => $partners
        ]);
    }
}
