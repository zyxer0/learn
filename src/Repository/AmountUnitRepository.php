<?php

namespace App\Repository;

use App\Entity\AmountUnit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AmountUnit|null find($id, $lockMode = null, $lockVersion = null)
 * @method AmountUnit|null findOneBy(array $criteria, array $orderBy = null)
 * @method AmountUnit[]    findAll()
 * @method AmountUnit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AmountUnitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AmountUnit::class);
    }

    // /**
    //  * @return AmountUnit[] Returns an array of AmountUnit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AmountUnit
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
