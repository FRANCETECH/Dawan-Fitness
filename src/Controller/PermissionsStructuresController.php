<?php

namespace App\Controller;

use App\Entity\PermissionsStructures;
use App\Form\PermissionsStructuresType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class PermissionsStructuresController extends AbstractController
{
  #[Route("/admin/register/permissions-structures")]
  public function new(Request $request, ManagerRegistry $doctrine): Response
  {
    $permission = new PermissionsStructures();
    $form = $this->createForm(PermissionsStructuresType::class, $permission);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $entityManager = $doctrine->getManager();

      $entityManager->persist($permission);
      $entityManager->flush();

      return $this->redirectToRoute("app_admin");
    }

    return $this->render("admin/structures/registerPermissionsStructures.html.twig", [
      "form" => $form->createView()
    ]);
  }
}