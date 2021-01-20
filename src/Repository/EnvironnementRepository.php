<?php

namespace App\Repository;

use App\Entity\Environnement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Environnement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Environnement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Environnement[]    findAll()
 * @method Environnement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnvironnementRepository extends ServiceEntityRepository
{
    public const PAGINATOR_PER_PAGE = 12;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Environnement::class);
    }

    public function getPaginator(int $offset): Paginator
    {
        $query = $this->createQueryBuilder('e')
            ->orderBy('e.createdAt', 'DESC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }

    // /**
    //  * @return Environnement[] Returns an array of Environnement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Environnement
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
