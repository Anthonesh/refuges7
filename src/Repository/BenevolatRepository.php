<?php

namespace App\Repository;

use App\Entity\Benevolat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Benevolat>
 */
class BenevolatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Benevolat::class);
    }

    /**
     * @return Benevolat[] Returns an array of Benevolat objects
     */
    public function findSlotsByDate(\DateTime $date): array
    {
        $startDate = $date->format('Y-m-d 00:00:00');
        $endDate = $date->format('Y-m-d 23:59:59');

        return $this->createQueryBuilder('b')
            ->andWhere('b.heure_debut_benevolat BETWEEN :startDate AND :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->orderBy('b.heure_debut_benevolat', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
