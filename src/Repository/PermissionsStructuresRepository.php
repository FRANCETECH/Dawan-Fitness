<?php

namespace App\Repository;

use App\Entity\PermissionsStructures;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PermissionsStructures>
 *
 * @method PermissionsStructures|null find($id, $lockMode = null, $lockVersion = null)
 * @method PermissionsStructures|null findOneBy(array $criteria, array $orderBy = null)
 * @method PermissionsStructures[]    findAll()
 * @method PermissionsStructures[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PermissionsStructuresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PermissionsStructures::class);
    }

    public function save(PermissionsStructures $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PermissionsStructures $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PermissionsStructures[] Returns an array of PermissionsStructures objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PermissionsStructures
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
