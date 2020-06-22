<?php

namespace App\Controller;

use App\Entity\Person;
use App\Security\UserAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dashboard", name="dashboard_")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('dashboard/index.html.twig');
    }

    /**
     * @Route("/admin/clients", name="admin_clients")
     */
    public function adminClientsList()
    {
        $clients = $this->getDoctrine()
            ->getRepository(Person::class)
            ->findBy(['hasCompany' => true]);
        return $this->render('dashboard/Admin/client.html.twig', ['clients' => $clients]);
    }
}
