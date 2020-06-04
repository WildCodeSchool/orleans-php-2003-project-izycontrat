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
        $userAuth = 'lawyer';
        return $this->render('dashboard/index.html.twig', [
            'auth' => $userAuth,
        ]);
    }
}
