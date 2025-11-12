<?php

namespace App\Repository;

use App\Entity\Citizen;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Citizen>
 */
class CitizenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Citizen::class);
    }

    public function findOneByNni(string $nni): ?Citizen
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.nni = :nni')
            ->setParameter('nni', $nni)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
