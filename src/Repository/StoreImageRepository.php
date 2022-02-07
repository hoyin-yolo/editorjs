<?php

namespace App\Repository;

use App\Entity\StoreImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StoreImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method StoreImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method StoreImage[]    findAll()
 * @method StoreImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StoreImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StoreImage::class);
    }

    // /**
    //  * @return StoreImage[] Returns an array of StoreImage objects
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
    public function findOneBySomeField($value): ?StoreImage
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
