<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<Users>
 *
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

    /*
    * Cette fonction est utilisée ici pour sauvegarder une entité (un objet de la classe Users). 
    * La fonction save attend un objet de la classe Users en entrée(Users $entity). L'entité est probablement un utilisateur à enregistrer dans la base de données.
    * Aussi un parametre de type bool (booléen) qui a une valeur par défaut de false. Il permet de définir si, après avoir persisté l'entité avec persist(), il faut également appeler
      flush() pour enregistrer immédiatement l'entité dans la base de données.
    */
    public function save(Users $entity, bool $flush = false): void
    {
        // Persiste l'entité $entity dans le contexte de l'EntityManager (mais pas encore dans la base de données).
        $this->getEntityManager()->persist($entity);

        // Si le paramètre $flush est true, exécute la méthode flush() pour réellement sauvegarder l'entité dans la base de données.
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // Elle est utilisée pour supprimer une entité (ici un objet de la classe Users).
    public function remove(Users $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     * Cette méthode est utilisée pour réinitialiser ou "rehash" automatiquement le mot de passe de l'utilisateur
     * lorsque cela est nécessaire, par exemple lors d'une modification des algorithmes de hachage.
     * Le premier parametre: Représente l'utilisateur dont le mot de passe est mis à jour. Ce paramètre doit implémenter l'interface PasswordAuthenticatedUserInterface.
     * Le second parametre: Est le nouveau mot de passe haché qui remplace l'ancien.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        // Vérifie si l'utilisateur fourni est bien une instance de la classe Users.
        // Si ce n'est pas le cas, lève une exception indiquant que ce type d'utilisateur n'est pas supporté.
        if (!$user instanceof Users) {
            // Lève une exception UnsupportedUserException si l'utilisateur n'est pas de type "Users"
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        // Met à jour le mot de passe de l'utilisateur avec le nouveau mot de passe haché.
        $user->setPassword($newHashedPassword);

        // Sauvegarde l'utilisateur avec son mot de passe mis à jour.
        // Le second argument 'true' indique que l'opération 'flush' est appelée immédiatement,
        // ce qui enregistre directement les modifications dans la base de données.
        $this->save($user, true);
    }




    /**
     * Récupère une liste d'utilisateurs actifs.
     * Cette méthode retourne un tableau d'utilisateurs dont le champ 'is_active' est défini à 1 (actif).
     */
    public function getActiveUsers(): array
    {
        // Crée un QueryBuilder pour l'entité 'Users' avec l'alias 'u'.
        $query = $this->createQueryBuilder("u")
            // Ajoute une condition pour ne sélectionner que les utilisateurs actifs (où 'is_active' est égal à 1).
            ->where("u.is_active = 1");

        // Exécute la requête et retourne les résultats sous forme de tableau d'entités 'Users'.
        return $query->getQuery()->getResult();
    }


    public function getInactiveUsers(): array
    {
        $query = $this->createQueryBuilder("u")
            ->where("u.is_active = 0");

        return $query->getQuery()->getResult();
    }

    /**
     * Récupère une liste d'utilisateurs en fonction de leur rôle.
     *
     * @param string $role Le rôle recherché (ex : 'ROLE_ADMIN', 'ROLE_USER').
     * 
     * @return array Un tableau d'utilisateurs correspondant au rôle donné ou recherché.
     */
    public function findByRole($role): array   // Ce paramètre représente le rôle à rechercher (par exemple, ROLE_ADMIN, ROLE_USER). Il s'agit d'une string passée à la requête pour filtrer les utilisateurs ayant ce rôle dans leurs données.
    {
        // Crée un QueryBuilder pour l'entité 'Users' avec l'alias 'u'.
        $query = $this->createQueryBuilder('u')
            // Ajoute une condition WHERE pour chercher des utilisateurs dont le champ 'roles' contient le rôle spécifié.
            ->where('u.roles LIKE :role')
            // Définit la valeur du paramètre ':role' pour correspondre à la chaîne de caractères fournie dans $role,
            // entourée de '%' pour effectuer une recherche partielle (LIKE).
            ->setParameter('role', '%' . $role . '%');

        // Exécute la requête et retourne les résultats sous forme de tableau d'entités 'Users'.
        return $query->getQuery()->getResult();
    }








    //    /**
//     * @return Users[] Returns an array of Users objects
//     */
//    public function showPermissionsUsers($id): array
//    {
//        $sql = $this->createNativeQuery('SELECT * FROM users 
//            JOIN permissions_users ON users.id = permissions_users.users_id
//            JOIN permissions ON permissions_users.permissions_id = permissions.id
//            WHERE users.id = ?');

    /*         $queryBuilder = $this->_em->createQueryBuilder()
                ->select([''])
                ->andWhere('u.id = :id')
                ->leftJoin('u.permissionsUsers', 'fc')
                ->addSelect('fc')
                ->setParameter('id', $id)
                ->getQuery()
            ;  */

    //        return $sql->getResult();
//    } 

    //    public function findOneBySomeField($value): ?Users
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }



}
