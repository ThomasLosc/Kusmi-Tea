<?php

namespace App\Repository;

use App\Entity\PointLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PointLog>
 *
 * @method PointLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method PointLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method PointLog[]    findAll()
 * @method PointLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PointLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PointLog::class);
    }

//    /**
//     * @return PointLog[] Returns an array of PointLog objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PointLog
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
