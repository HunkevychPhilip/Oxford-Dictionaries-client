<?php

namespace App\Repository;

use App\Entity\Searches;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Searches|null find($id, $lockMode = null, $lockVersion = null)
 * @method Searches|null findOneBy(array $criteria, array $orderBy = null)
 * @method Searches[]    findAll()
 * @method Searches[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SearchesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Searches::class);
    }

     /**
      * @return Searches[] Returns an array of Searches objects
      */
    public function findTopHighestSearch()
    {
        $qb = $this->createQueryBuilder('r');

        $qb->select('r.title', 'r.searched')
            ->orderBy('r.searched', 'DESC')
            ->setMaxResults(50);

        $query = $qb->getQuery();

        return $query->execute();
    }
}
