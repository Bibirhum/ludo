<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @return User[] Returns an array of User objects
     */

    /*public function findByFields(?string $game, ?string $zipcode, ?string $city)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.username LIKE :username')
            ->orWhere('u.zipCode LIKE :zipcode')
            ->orWhere('u.city LIKE :city')

            ->setParameter('username', '%'.$game.'%')
            ->setParameter('zipcode', '%'.$zipcode.'%')
            ->setParameter('city', '%'.$city.'%')

            ->orderBy('u.username', 'ASC')
            //->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }*/

    public function findByCity(?string $city)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
            SELECT u
            FROM App\Entity\User u
            WHERE u.city LIKE :city
            ORDER BY u.username ASC
        ')

        ->setParameter('city', $city);

        return $query->execute();

    }

//INNER JOIN App\Entity\UserGameAssociation a
//ON u.id = a.users
//INNER JOIN App\Entity\Game g
//ON a.games = g.id


    // /**
    //  * @return User[] Returns an array of User objects
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
    public function findOneBySomeField($value): ?User
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
