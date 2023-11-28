<?php

namespace App\Repository;

use App\Entity\Movie;
use App\Models\Search\MovieSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Movie>
 *
 * @method Movie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movie[]    findAll()
 * @method Movie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movie::class);
    }

    /**
     * @param MovieSearch $search
     * @return Query
     */
    public function getAll(MovieSearch $search): Query
    {
        $qb = $this->getAllQueryBuilder($search);
        return $qb->getQuery();
    }

    /**
     * @param MovieSearch $search
     * @return QueryBuilder
     */
    public function getAllQueryBuilder(MovieSearch $search): QueryBuilder
    {
        $qb = $this->createQueryBuilder('m');
        $qb->innerJoin('m.userMovies', 'um');

        if(null !== $search->getUser()){
            $qb->andWhere('um.user = :user')
                ->setParameter('user', $search->getUser());
        }

        $qb->orderBy('m.title');

        return $qb;
    }
}
