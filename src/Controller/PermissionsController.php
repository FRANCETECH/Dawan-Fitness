<?php

namespace App\Controller;

use App\Entity\Permissions;
use App\Form\PermissionsType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PermissionsController extends AbstractController
{
  #[Route("/admin/register/permission")]
  public function new(Request $request, ManagerRegistry $doctrine): Response
  {
    $permissions = new Permissions();
    $form = $this->createForm(PermissionsType::class, $permissions);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $entityManager = $doctrine->getManager();

      $entityManager->persist($permissions);
      $entityManager->flush();

      return $this->redirectToRoute("app_admin");
    }

    return $this->render("admin/permissions/registerPermission.html.twig", [
      "form" => $form->createView()
    ]);
  }

  #[Route("/admin/edit/permission/{id}", name: "edit_permission")]
  public function edit(Request $request, ManagerRegistry $doctrine, Permissions $permission): Response
  {
    $form = $this->createForm(PermissionsType::class, $permission);

    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $doctrine->getManager()->flush();
    }

    return $this->render("admin/permissions/editPermission.html.twig", [
      "form" => $form->createView()
    ]);
  }

  #[Route("/admin/delete/permission/{id}", name: "delete_permission")]
  public function delete(ManagerRegistry $doctrine, Permissions $permission): Response
  {
    $entityManager = $doctrine->getManager();
    $entityManager->remove($permission);
    $entityManager->flush();

    return $this->redirectToRoute("app_admin");
  }

  #[Route("/admin/disable/permission/{id}", name: "disable_permission")]
  public function disable(ManagerRegistry $doctrine, Permissions $permission):Response
  {
    $entityManager = $doctrine->getManager();
    $permission->setIsActive(false);
    $entityManager->flush($permission);

    return $this->redirectToRoute("read_all_permission");
  }

  #[Route("/admin/enable/permission/{id}", name: "enable_permission")]
  public function enable(ManagerRegistry $doctrine, Permissions $permission):Response
  {
    $entityManager = $doctrine->getManager();
    $permission->setIsActive(true);
    $entityManager->flush($permission);

    return $this->redirectToRoute("read_all_permission");
  }

  #[Route("/admin/permission/read-all", name: "read_all_permission")]
  public function readAll(ManagerRegistry $doctrine): Response
  {
    $repository = $doctrine->getRepository(Permissions::class);
    $permissions = $repository->findAll();
    return $this->render("admin/permissions/readAllPermissions.html.twig", [
      "permissions" => $permissions
    ]);
  }
}