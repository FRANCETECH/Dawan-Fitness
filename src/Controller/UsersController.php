<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UsersRepository;

class UsersController extends AbstractController
{

  // méthode qui crée un nouvel utilisateur, enregistre ses informations, envoie un email de bienvenue, et encode son mot de passe avant de sauvegarder l'utilisateur dans la base de données.
  #[Route("/admin/register/user", name: "admin_home")]
  public function new(
    Request $request,  // L'objet Request contient les données de la requête HTTP (POST, GET, etc.).
    UserPasswordHasherInterface $userPasswordHasher,  // Interface pour hacher (encoder) le mot de passe de l'utilisateur.
    ManagerRegistry $doctrine,  // Accès aux objets de gestion des entités pour manipuler la base de données.
    MailerInterface $mailer  // Interface pour envoyer des emails.
  ): Response  // La fonction retourne une réponse HTTP (Response).
  {
    // Création d'un nouvel objet `Users`, qui représente un nouvel utilisateur.
    $user = new Users();

    // Création du formulaire pour l'objet `Users` à partir d'une classe de formulaire `UsersType`.
    $form = $this->createForm(UsersType::class, $user);

    // Traitement de la requête HTTP (POST) et liaison des données du formulaire à l'objet `$user`.
    $data = $form->handleRequest($request);

    // Vérification si le formulaire a été soumis et est valide.
    if ($form->isSubmitted() && $form->isValid()) {
      // **Envoi d'un email de bienvenue au nouvel utilisateur**.
      // Création d'un nouvel email basé sur un modèle (templated email).
      $email = (new TemplatedEmail())
        ->from("dev.technologie2018@gmail.com")  // Adresse email de l'expéditeur.
        ->to($data->get("email")->getData())  // Adresse email du destinataire (récupérée depuis le formulaire).
        ->subject("Bienvenue chez Dawan by Jehann !")  // Sujet de l'email.
        ->htmlTemplate("emails/signup.html.twig")  // Template HTML pour le corps de l'email.
        ->context([  // Données passées au template pour l'email.
          "name" => $data->get("name")->getData(),  // Nom de l'utilisateur.
          "mail" => $data->get("email")->getData(),  // Email de l'utilisateur.
          "role" => $data->get("roles")->getData(),  // Rôle(s) de l'utilisateur.
          "structures" => $data->get("structures")->getData()  // Structures de l'utilisateur.
        ]);

      // Envoi de l'email à l'utilisateur via l'interface `MailerInterface`.
      $mailer->send($email);

      // **Encodage (hachage) du mot de passe de l'utilisateur**.
      // Le mot de passe brut est récupéré depuis le formulaire et encodé (haché) avant d'être stocké.
      $user->setPassword(
        $userPasswordHasher->hashPassword(
          $user,  // L'objet utilisateur.
          $form->get("password")->getData()  // Mot de passe en clair récupéré du formulaire.
        )
      );

      // **Gestion des entités avec Doctrine**.
      // Récupération du gestionnaire d'entité (EntityManager) pour persister les données dans la base de données.
      $entityManager = $doctrine->getManager();

      // Persistance de l'objet utilisateur (préparation pour l'insertion en base de données).
      $entityManager->persist($user);

      // Exécution des requêtes SQL pour sauvegarder les changements (ajout de l'utilisateur en base de données).
      $entityManager->flush();

      // Redirection vers la route nommée "app_admin" après succès.
      return $this->redirectToRoute("app_admin");
    }

    // Si le formulaire n'est pas soumis ou n'est pas valide, rendre la vue de la page d'inscription.
    return $this->render("admin/users/registerUser.html.twig", [
      "form" => $form->createView()  // Passer la vue du formulaire à la vue Twig pour affichage.
    ]);
  }


  #[Route("/admin/edit/user/{id}", name: "edit_user")]
  public function edit(
    Request $request,
    UserPasswordHasherInterface $userPasswordHasher,
    ManagerRegistry $doctrine,
    Users $user,
    MailerInterface $mailer
  ): Response {
    $form = $this->createForm(UsersType::class, $user);

    $data = $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      // send email to the modify user 
      $email = (new TemplatedEmail())
        ->from("admin@lorangebleue.com")
        ->to($data->get("email")->getData())
        ->subject("Modification sur votre compte")
        ->htmlTemplate("emails/update.html.twig")
        ->context([
          "name" => $data->get("name")->getData(),
          "mail" => $data->get("email")->getData(),
          "role" => $data->get("roles")->getData(),
          "structures" => $data->get("structures")->getData()
        ]);
      $mailer->send($email);

      $user->setPassword(
        $userPasswordHasher->hashPassword(
          $user,
          $form->get("password")->getData()
        )
      );
      $entityManager = $doctrine->getManager();
      $entityManager->flush();
    }

    return $this->render("admin/users/editUser.html.twig", [
      "form" => $form->createView()
    ]);
  }

  #[Route("/admin/delete/user/{id}", name: "delete_user")]
  public function delete(ManagerRegistry $doctrine, Users $user): Response
  {
    $entityManager = $doctrine->getManager();
    $entityManager->remove($user);
    $entityManager->flush();

    return $this->redirectToRoute("app_admin");
  }

  #[Route("/admin/disable/user/{id}", name: "disable_user")]
  public function disable(ManagerRegistry $doctrine, Users $user): Response
  {
    // Récupération du gestionnaire d'entité (EntityManager) via Doctrine.
    $entityManager = $doctrine->getManager();
    // Modification de l'utilisateur passé en paramètre.
    // La propriété `isActive` de l'utilisateur est définie sur `false` pour indiquer qu'il est désactivé.
    $user->setIsActive(false);

    // Appel de flush() sans argument
    $entityManager->flush();

    return $this->redirectToRoute("read_all_user");
  }


  #[Route("/admin/enable/user/{id}", name: "enable_user")]
  public function enable(ManagerRegistry $doctrine, Users $user): Response
  {
    $entityManager = $doctrine->getManager();
    $user->setIsActive(true);

    // Appel de flush() sans argument
    $entityManager->flush();

    return $this->redirectToRoute("read_all_user");
  }


  // méthode Symfony qui permet de lire et de filtrer une liste d'utilisateurs en fonction de divers critères, tout en gérant des requêtes AJAX pour un rendu dynamique des résultats.
  #[Route("/admin/user/read-all", name: "read_all_user")]
  // La fonction `readAll` est publique et retourne une réponse HTTP.
  public function readAll(ManagerRegistry $doctrine, Request $request, UsersRepository $repositoryUser): Response
  {
    // **Récupération des filtres depuis la requête**.
    // On récupère les valeurs envoyées via la requête HTTP (GET ou POST).
    // Chaque filtre correspond à un critère spécifique sur les utilisateurs : actifs, inactifs, partenaires, managers, administrateurs.
    $filterActiveUser = $request->get("activeUser");
    $filterInactiveUser = $request->get("inactiveUser");
    $filterPartner = $request->get("partner");
    $filterManager = $request->get("manager");
    $filterAdmin = $request->get("admin");

    // Variable qui stockera les utilisateurs récupérés après filtrage.
    $users = "";

    // **Application des filtres**.
    // On vérifie chaque filtre et on appelle les méthodes appropriées du repository.
    if ($filterActiveUser == true) {
      // Si le filtre des utilisateurs actifs est activé, on récupère tous les utilisateurs actifs.
      $users = $repositoryUser->getActiveUsers();
    } elseif ($filterInactiveUser == true) {
      // Si le filtre des utilisateurs inactifs est activé, on récupère les utilisateurs inactifs.
      $users = $repositoryUser->getInactiveUsers();
    } elseif ($filterPartner == true) {
      // Si le filtre des partenaires est activé, on récupère les utilisateurs ayant le rôle `ROLE_PARTNER`.
      $users = $repositoryUser->findByRole('"ROLE_PARTNER"');
    } elseif ($filterManager == true) {
      // Si le filtre des managers est activé, on récupère les utilisateurs ayant un rôle spécifique (ici, il semble que le rôle n'est pas défini ou vide).
      $users = $repositoryUser->findByRole("[]");
    } elseif ($filterAdmin == true) {
      // Si le filtre des administrateurs est activé, on récupère les utilisateurs ayant le rôle `ROLE_ADMIN`.
      $users = $repositoryUser->findByRole('"ROLE_ADMIN"');
    } else {
      // Si aucun filtre n'est activé, on récupère tous les utilisateurs.
      $users = $repositoryUser->findAll();
    }

    // **Gestion des requêtes AJAX**.
    // Si la requête est une requête AJAX, c'est-à-dire que l'on souhaite charger les données dynamiquement sans recharger toute la page.
    if ($request->get("ajax")) {
      // On retourne une réponse JSON contenant le rendu partiel d'un template (une vue) avec les utilisateurs filtrés.
      return new JsonResponse([
        "content" => $this->renderView("admin/users/_content.html.twig", [
          "users" => $users  // On passe les utilisateurs filtrés à la vue Twig partielle.
        ])
      ]);
    }

    // **Rendu classique (non AJAX)**.
    // Si ce n'est pas une requête AJAX, on rend la page entière avec la liste des utilisateurs.
    return $this->render("admin/users/readAllUsers.html.twig", [
      "users" => $users  // On passe les utilisateurs filtrés à la vue Twig complète.
    ]);
  }




}


// https://chatgpt.com/c/66faae7b-0e4c-800a-a98c-376f504b692f