<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LawyerController extends AbstractController
{
    /**
     * @Route("/lawyer", name="lawyer")
     * @param UserRepository $userRepo
     * @return Response
     */
    public function index(UserRepository $userRepo) :Response
    {
        $lawyers = $userRepo->getAllLawyers();

        return $this->render('lawyer/index.html.twig', [
            'lawyers' => $lawyers
        ]);
    }
}
