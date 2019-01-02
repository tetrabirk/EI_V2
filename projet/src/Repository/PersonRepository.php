<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
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
    public function searchPersons($searchString,$site,$role,$company)
    {
        $qb = $this->createQueryBuilder('p');

        $string = '%' . $searchString . '%';

        $qb->where('p.name LIKE :string');
        $qb->orWhere('p.firstname LIKE :string');
        $qb->setParameter('string', $string);

        if ($site || $role ){
            if($site){
                $qb->join('p.participations','pa','WITH',$qb->expr()->in('pa.site',$site));
                if($role){
                    $qb->andWhere('pa.role LIKE :role');
                    $qb->setParameter('role', $role);
                }
            }
            else{
                $qb->leftJoin('p.participations','pa')->addSelect('pa');
                $qb->andWhere('pa.role LIKE :role');
                $qb->setParameter('role', $role);
            }


        }else{
            $qb->leftJoin('p.participations','pa')->addSelect('pa');
        }
        if($company){
            $qb->andWhere('p.company LIKE :company');
            $qb->setParameter('company', $company);
        }

        // $qb->groupBy('wd.id');
        // $qb->orderBy('wd.date DESC'); //TODO pas moyen de changer le sens (???)
        $query = $qb->getQuery();
        return $query->getResult();
    }


}
