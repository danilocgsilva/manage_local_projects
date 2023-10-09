<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\DatabaseCredentials;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DatabaseCredentials>
 *
 * @method DatabaseCredentials|null find($id, $lockMode = null, $lockVersion = null)
 * @method DatabaseCredentials|null findOneBy(array $criteria, array $orderBy = null)
 * @method DatabaseCredentials[]    findAll()
 * @method DatabaseCredentials[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DatabaseCredentialsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DatabaseCredentials::class);
    }

//    /**
//     * @return DatabaseCredentials[] Returns an array of DatabaseCredentials objects
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

//    public function findOneBySomeField($value): ?DatabaseCredentials
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
