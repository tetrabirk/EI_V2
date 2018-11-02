<?php

namespace App\Repository;

use App\Entity\CompletedTask;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CompletedTask|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompletedTask|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompletedTask[]    findAll()
 * @method CompletedTask[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompletedTaskRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CompletedTask::class);
    }

//    /**
//     * @return CompletedTask[] Returns an array of CompletedTask objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CompletedTask
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
