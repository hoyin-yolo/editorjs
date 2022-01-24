<?php

namespace App\Repository;

use App\Entity\JSONPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method JSONPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method JSONPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method JSONPost[]    findAll()
 * @method JSONPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JSONPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JSONPost::class);
    }

    // /**
    //  * @return JSONPost[] Returns an array of JSONPost objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JSONPost
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
