<?php

namespace App\Repository;

use App\Entity\UserGameAssociation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserGameAssociation|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserGameAssociation|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserGameAssociation[]    findAll()
 * @method UserGameAssociation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserGameAssociationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserGameAssociation::class);
    }

    public function findByFields(?string $game, ?string $city)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
            SELECT a
            FROM App\Entity\User u, App\Entity\UserGameAssociation a, App\Entity\Game g
            WHERE u.id = a.users AND a.games = g.id
            AND g.name LIKE :game AND u.city LIKE :city
            ORDER BY u.username ASC
        ')

            ->setParameter('game', $game)
            ->setParameter('city', $city);

        return $query->execute();

    }

    // /**
    //  * @return UserGameAssociation[] Returns an array of UserGameAssociation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserGameAssociation
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

    
