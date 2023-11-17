<?php

namespace App\Repository;

use App\Entity\Deploy;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Deploy>
 *
 * @method Deploy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Deploy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Deploy[]    findAll()
 * @method Deploy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeployRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Deploy::class);
    }

//    /**
//     * @return Deploy[] Returns an array of Deploy objects
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

//    public function findOneBySomeField($value): ?Deploy
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
