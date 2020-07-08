<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\RegistrationUserType;
use App\Security\UserAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        $user = $this->getUser();
        $person = $this->getDoctrine()->getRepository(Person::class)->findOneBy(['user' => $user]);
        return $this->render(
            'dashboard/index.html.twig',
            [
            'user' => $user,
            'person' => $person
            ]
        );
    }

    /**
     * @Route("/profile", name="profile")
     * @param Request $request
     * @return Response
     */
    public function profile(Request $request): Response
    {
        $user = $this->getUser();
        $person = $this->getDoctrine()->getRepository(Person::class)->findOneBy(['user' => $user]);
        $form = $this->createForm(RegistrationUserType::class, $person);
        $form->handleRequest($request);
        return $this->render(
            'dashboard/profile.html.twig',
            ['form' => $form->createView(),]
        );
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

    /**
     * @Route("/admin/clients/{id}", name="admin_clients_show")
     * @param Person $client
     * @return Response
     */
    public function adminClientsShow(Person $client)
    {
        return $this->render('dashboard/Admin/show.html.twig', ['client' => $client]);
    }
}
