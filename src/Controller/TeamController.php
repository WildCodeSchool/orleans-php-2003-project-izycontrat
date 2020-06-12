<?php

namespace App\Controller;

use App\Entity\TeamMember;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    /**
     * @Route("/team", name="team")
     */
    public function index()
    {
        $members = $this->getDoctrine()
            ->getRepository(TeamMember::class)
            ->findAll();

        return $this->render('team/index.html.twig', [
            'members' => $members,
        ]);
    }
}
