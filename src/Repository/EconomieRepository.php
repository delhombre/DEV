<?php

namespace App\Repository;

use App\Entity\Economie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Economie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Economie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Economie[]    findAll()
 * @method Economie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EconomieRepository extends ServiceEntityRepository
{
    public const PAGINATOR_PER_PAGE = 12;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Economie::class);
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
    //  * @return Economie[] Returns an array of Economie objects
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
    public function findOneBySomeField($value): ?Economie
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
