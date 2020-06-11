<?php

namespace App\Repository;

use App\Entity\TeamMember;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TeamMember|null find($id, $lockMode = null, $lockVersion = null)
 * @method TeamMember|null findOneBy(array $criteria, array $orderBy = null)
 * @method TeamMember[]    findAll()
 * @method TeamMember[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamMemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeamMember::class);
    }
}
