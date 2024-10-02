<?php

namespace App\Repository;

use App\Entity\Structures;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Structures>
 *
 * @method Structures|null find($id, $lockMode = null, $lockVersion = null)
 * @method Structures|null findOneBy(array $criteria, array $orderBy = null)
 * @method Structures[]    findAll()
 * @method Structures[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StructuresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Structures::class);
    }

    public function save(Structures $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Structures $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Returns all active structures
     *
     * @return void
     */
    public function getActiveStructures()
    {
        $query = $this->createQueryBuilder("s")
            ->where("s.is_active = 1");
        
        return $query->getQuery()->getResult();
    }

    /**
     * Returns all inactive structures
     *
     * @return void
     */
    public function getInactiveStructures()
    {
        $query = $this->createQueryBuilder("s")
            ->where("s.is_active = 0");
        
            return $query->getQuery()->getResult();
    }
//    /**
//     * @return Structures[] Returns an array of Structures objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Structures
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
