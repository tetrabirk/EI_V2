<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Person|null find($id, $lockMode = null, $lockVersion = null)
 * @method Person|null findOneBy(array $criteria, array $orderBy = null)
 * @method Person[]    findAll()
 * @method Person[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Person::class);
    }

    public function getPersonList()
    {
        $qb = $this->createQueryBuilder('p');

        $qb->leftJoin('p.participations','pa')->addSelect('pa');

        $query = $qb->getQuery();
        return $query->getResult();
    }

    public function getOnePerson($id)
    {
        $qb = $this->createQueryBuilder('p');

        $qb->leftJoin('p.participations','pa')->addSelect('pa');
        $qb->leftJoin('pa.site','si')->addSelect('si');


        $qb->andWhere('p.id = :id');
        $qb->setParameter('id',$id);

        $query = $qb->getQuery();
        return $query->getResult();
    }
}
