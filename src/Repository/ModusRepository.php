<?php

namespace App\Repository;

use App\Entity\Modus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Modus|null find($id, $lockMode = null, $lockVersion = null)
 * @method Modus|null findOneBy(array $criteria, array $orderBy = null)
 * @method Modus[]    findAll()
 * @method Modus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModusRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Modus::class);
    }

    // /**
    //  * @return Modus[] Returns an array of Modus objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Modus
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
