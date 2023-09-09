<?php

namespace App\Repository;

use App\Entity\Bookmark;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bookmark>
 *
 * @method Bookmark|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bookmark|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bookmark[]    findAll()
 * @method Bookmark[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookmarkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bookmark::class);
    }

    /**
     * Get bookmarks with Picture & Movie join
     * @return Bookmark[] Returns an array of Bookmark objects
     */
    public function getBookmarks(): array
    {
        return $this->createQueryBuilder('b')
            ->leftJoin('b.picture', 'p')
            ->leftJoin('b.movie', 'm')
            ->addSelect(['p', 'm'])
            ->getQuery()
            ->getResult();
    }

    /**
     * Get 1 bookmark with Picture & Movie join
     * @return Bookmark Returns a Bookmark object
     */
    public function getOneBookmark($id): ?Bookmark
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.id = :id')
            ->setParameter(':id', $id)
            ->leftJoin('b.picture', 'p')
            ->leftJoin('b.movie', 'm')
            ->addSelect(['p', 'm'])
            ->getQuery()
            ->getOneOrNullResult();
    }

    //    /**
    //     * @return Bookmark[] Returns an array of Bookmark objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Bookmark
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
