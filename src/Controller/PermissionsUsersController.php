<?php

namespace App\Controller;

use App\Entity\PermissionsUsers;
use App\Form\PermissionsUsersType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class PermissionsUsersController extends AbstractController
{
  #[Route("/admin/register/permissions-users")]
  public function new(
    Request $request, 
    ManagerRegistry $doctrine, 
    MailerInterface $mailer
  ): Response
  {
    $permission = new PermissionsUsers();
    $form = $this->createForm(PermissionsUsersType::class, $permission);
    $data = $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      // send email to the user with a new permission
      $email = (new TemplatedEmail())
      ->from("admin@lorangebleue.com")
      ->to($data->get("Users")->getData()->getEmail())
      ->subject("Ajout d'une permission")
      ->htmlTemplate("emails/addPermission.html.twig")
      ->context([
        "user" => $data->get("Users")->getData(),
        "permission" => $data->get("Permissions")->getData(),
      ]);
      $mailer->send($email);
      $entityManager = $doctrine->getManager();

      $entityManager->persist($permission);
      $entityManager->flush();

      return $this->redirectToRoute("app_admin");
    }

    return $this->render("admin/users/registerPermissionsUsers.html.twig", [
      "form" => $form->createView()
    ]);
  }
}