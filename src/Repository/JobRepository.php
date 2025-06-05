<?php

namespace App\Repository;

use App\Entity\Job;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Job>
 */
class JobRepository extends ServiceEntityRepository
{
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Job::class);
        $this->paginator = $paginator;
    }

    //    /**
    //     * @return Job[] Returns an array of Job objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('j')
    //            ->andWhere('j.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('j.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Job
    //    {
    //        return $this->createQueryBuilder('j')
    //            ->andWhere('j.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findByFilters(?string $category, ?string $country, int $page = 1)
    {
        $qb = $this->createQueryBuilder('j')
            ->leftJoin('j.company', 'c')
            ->leftJoin('j.categories', 'jc')
            ->orderBy('j.createdAt', 'DESC');

        if ($category) {
            $qb->andWhere('jc.name = :category')
               ->setParameter('category', $category);
        }

        if ($country) {
            $qb->andWhere('j.country = :country')
               ->setParameter('country', $country);
        }

        $query = $qb->getQuery();

        return $this->paginator->paginate(
            $query,
            $page,
            10
        );
    }

    public function findAllCountries(): array
    {
        return $this->createQueryBuilder('j')
            ->select('DISTINCT j.country')
            ->where('j.country IS NOT NULL')
            ->orderBy('j.country', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
