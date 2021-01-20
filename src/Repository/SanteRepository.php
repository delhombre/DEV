<?php

namespace App\Repository;

use App\Entity\Sante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sante|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sante|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sante[]    findAll()
 * @method Sante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SanteRepository extends ServiceEntityRepository
{
    public const PAGINATOR_PER_PAGE = 12;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sante::class);
    }

    public function getPaginator(int $offset): Paginator
    {
        $query = $this->createQueryBuilder('s')
            ->orderBy('s.createdAt', 'DESC')
            ->setMaxResults(self::PAGINATOR_PER_PAGE)
            ->setFirstResult($offset)
            ->getQuery();

        return new Paginator($query);
    }

    // /**
    //  * @return Sante[] Returns an array of Sante objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sante
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
