<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard", name="area_")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="member")
     */
    public function index()
    {
        return $this->render('dashboard/index.html.twig', [
            'auth' => 'lawyer',
        ]);
    }
}
