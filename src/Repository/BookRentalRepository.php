<?php

namespace App\Repository;

use App\Entity\BookRental;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BookRental|null find($id, $lockMode = null, $lockVersion = null)
 * @method BookRental|null findOneBy(array $criteria, array $orderBy = null)
 * @method BookRental[]    findAll()
 * @method BookRental[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookRentalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookRental::class);
    }

    // /**
    //  * @return BookRental[] Returns an array of BookRental objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BookRental
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
