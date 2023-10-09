<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\GitAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GitAddress>
 *
 * @method GitAddress|null find($id, $lockMode = null, $lockVersion = null)
 * @method GitAddress|null findOneBy(array $criteria, array $orderBy = null)
 * @method GitAddress[]    findAll()
 * @method GitAddress[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GitAddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GitAddress::class);
    }

//    /**
//     * @return GitAddress[] Returns an array of GitAddress objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GitAddress
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
