<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Game::class);
    }

    public function findByFields(
        ?string $name,
        ?string $category,
        ?int $numPlayerMin,
        ?int $numPlayerMax,
        ?int $duration,
        ?int $ageMin
        )
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
            SELECT g
            FROM App\Entity\Game g, App\Entity\Category c
            WHERE g.category = c.id
            AND g.name LIKE :name
            AND c.name LIKE :category
            AND g.numPlayerMin >= :numPlayerMin
            AND g.numPlayerMax <= :numPlayerMax
            AND g.duration <= :duration
            AND g.ageMin >= :ageMin
            ORDER BY g.name ASC
        ')
            ->setParameter('name', $name)
            ->setParameter('category', $category)
            ->setParameter('numPlayerMin', $numPlayerMin)
            ->setParameter('numPlayerMax', $numPlayerMax)
            ->setParameter('duration', $duration)
            ->setParameter('ageMin', $ageMin);

        return $query->execute();
    }
    // /**
    //  * @return Game[] Returns an array of Game objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Game
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
