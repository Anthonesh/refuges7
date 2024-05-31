<?php

namespace App\Repository;

use App\Entity\Calendrier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @extends ServiceEntityRepository<Calendrier>
 *
 * @method Calendar|null find($id, $lockMode = null, $lockVersion = null)
 * @method Calendar|null findOneBy(array $criteria, array $orderBy = null)
 * @method Calendar[]    findAll()
 * @method Calendar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalendrierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Calendrier::class);
    }

    /**
     * @return Calendrier[] Returns an array of Calendar objects
     */
    public function findSlotsByDate(\DateTime $date): array
    {
        $startDate = $date->format('Y-m-d 08:00:00');
        $endDate = $date->format('Y-m-d 20:00:00');

        return $this->createQueryBuilder('c')
            ->andWhere('c.debut_calendrier BETWEEN :startDate AND :endDate')
            ->setParameter('startDate', $startDate)
            ->setParameter('endDate', $endDate)
            ->orderBy('c.debut_calendrier', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
