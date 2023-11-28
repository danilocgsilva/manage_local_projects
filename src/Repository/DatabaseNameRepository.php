<?php

namespace App\Repository;

use App\Entity\DatabaseName;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DatabaseName>
 *
 * @method DatabaseName|null find($id, $lockMode = null, $lockVersion = null)
 * @method DatabaseName|null findOneBy(array $criteria, array $orderBy = null)
 * @method DatabaseName[]    findAll()
 * @method DatabaseName[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DatabaseNameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DatabaseName::class);
    }

//    /**
//     * @return DatabaseName[] Returns an array of DatabaseName objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DatabaseName
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
