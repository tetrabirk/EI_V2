<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
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

    /**
     * @return QueryBuilder
     */
    public function getCompaniesSimple()
    {
        $qb = $this->createQueryBuilder('p');
        $qb->orderBy('p.company','ASC');
        $qb->groupBy('p.company');
        return $qb;
    }

    public function searchPersons($searchString,$site,$role,$company)
    {
        $qb = $this->createQueryBuilder('p');

        $string = '%' . $searchString . '%';

        $qb->where('p.name LIKE :string');
        $qb->orWhere('p.firstName LIKE :string');
        $qb->setParameter('string', $string);


        if ($site || $role ){

            if($site){
                if($role){
                    $qb->join('p.participations','pa','WITH',$qb->expr()->in('pa.site',$site));
                    $qb->join('p.participations','pa','WITH',$qb->expr()->in('pa.site',$site));

                }else{
                    $qb->join('p.participations','pa','WITH',$qb->expr()->in('pa.site',$site));
                }
            }
            else{
                $qb->join('p.participations','pa', Join::WITH ,$qb->expr()->in('pa.role' ,$role));
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
