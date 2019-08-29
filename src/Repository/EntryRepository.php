<?php

namespace App\Repository;

use App\Entity\Entry;
use App\Entity\Tag;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Entry|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entry|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entry[]    findAll()
 * @method Entry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Entry::class);
    }


    public function findLatest(int $page = 1, Tag $tag = null): Paginator
    {
        $qb = $this->createQueryBuilder('e')
            ->addSelect('u', 't')
            ->innerJoin('e.user', 'u')
            ->leftJoin('e.tagID', 't')
            ->where('e.created <= :now')
            ->orderBy('e.created', 'DESC')
            ->setParameter('now', new \DateTime())
        ;
        if (null !== $tag) {
            $qb->andWhere(':tag MEMBER OF e.tagID')
                ->setParameter('tag', $tag);
        }
        return (new Paginator($qb))->paginate($page);
    }
}
