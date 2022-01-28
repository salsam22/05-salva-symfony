<?php

namespace App\Repository;

use App\Entity\Shirt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Shirt|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shirt|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shirt[]    findAll()
 * @method Shirt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShirtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shirt::class);
    }

    // /**
    //  * @return Shirt[] Returns an array of Shirt objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Shirt
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
