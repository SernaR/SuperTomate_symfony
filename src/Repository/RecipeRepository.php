<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Recipe|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipe|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipe[]    findAll()
 * @method Recipe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    public function recipesPerCategory($category)
    {
        return $this->createQueryBuilder('r')
        ->select('r')
        ->join('r.category', 'c')
        ->andWhere('c.name = :category')
        ->andWhere('r.isDraft = :false')
        ->setParameter('false', false)
        ->setParameter('category', $category)
        ->orderBy('r.name', 'ASC')
        ->getQuery()
        ->getResult();
    }

    public function lastRecipes()
    {
        return $this->createQueryBuilder('r')
        ->select('r')
        ->andWhere('r.isDraft = :false')
        ->setParameter('false', false)
        ->orderBy('r.createdAt', 'DESC')
        ->setMaxResults(8)
        ->getQuery()
        ->getResult();

    }

    // /**
    //  * @return Recipe[] Returns an array of Recipe objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Recipe
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
