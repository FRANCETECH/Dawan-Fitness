<?php

namespace App\Controller;

use App\Entity\Structures;
use App\Entity\Users;
use App\Repository\PermissionsStructuresRepository;
use App\Repository\PermissionsUsersRepository;
use App\Repository\StructuresRepository;
use App\Repository\UsersRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManagerController extends AbstractController
{
    #[Route("/manager", name: "app_manager")]
    public function managerHome(UsersRepository $repository): Response
    {
        $id = $this->getUser()->getId();
        $user = $repository->find($id);
        return $this->render("manager/managerHome.html.twig", [
            "user" => $user
        ]);
    }

    #[Route("/manager/disable/permission/{idPermission}", name: "disable_permission_manager")]
    public function disablePermission(ManagerRegistry $doctrine, PermissionsUsersRepository $repo, int $idPermission):Response
    {
        $entityManager = $doctrine->getManager();
        $id = $this->getUser()->getId();
        $permissionUser = $repo->findOneBy(array("Permissions" => $idPermission, "users" => $id))->setIsActive(false);
        $entityManager->flush($permissionUser);

        return $this->redirectToRoute("app_manager");
    }

    #[Route("/manager/enable/permission/{idPermission}", name: "enable_permission_manager")]
    public function enablePermission(ManagerRegistry $doctrine, PermissionsUsersRepository $repo, int $idPermission):Response
    {
        $entityManager = $doctrine->getManager();
        $id = $this->getUser()->getId();
        $permissionUser = $repo->findOneBy(array("Permissions" => $idPermission, "users" => $id))->setIsActive(true);
        $entityManager->flush($permissionUser);

        return $this->redirectToRoute("app_manager");
    }

    #[Route("/manager/disable/structure/{idStructure}", name: "disable_structure_manager")]
    public function disableStructure(ManagerRegistry $doctrine, StructuresRepository $repo, int $idStructure):Response
    {
        $entityManager = $doctrine->getManager();
        $structure = $repo->find($idStructure)->setIsActive(false);
        $entityManager->flush($structure);

        return $this->redirectToRoute("app_manager");
    }

    #[Route("/manager/enable/structure/{idStructure}", name: "enable_structure_manager")]
    public function enableStructure(ManagerRegistry $doctrine, StructuresRepository $repo, int $idStructure):Response
    {
        $entityManager = $doctrine->getManager();
        $structure = $repo->find($idStructure)->setIsActive(true);
        $entityManager->flush($structure);

        return $this->redirectToRoute("app_manager");
    }

    #[Route("/manager/disable/permission/structure/{idPermission}{idStructure}", name: "disable_permission_structure_manager")]
    public function disablePermissionStructure(ManagerRegistry $doctrine, PermissionsStructuresRepository $repo, int $idPermission, int $idStructure):Response
    {
        $entityManager = $doctrine->getManager();
        $permissionStructure = $repo->findOneBy(array("permissions" => $idPermission, "structures" => $idStructure))->setIsActive(false);
        $entityManager->flush($permissionStructure);

        return $this->redirectToRoute("app_manager");
    }

    #[Route("/manager/enable/permission/structure/{idPermission}{idStructure}", name: "enable_permission_structure_manager")]
    public function enablePermissionStructure(ManagerRegistry $doctrine, PermissionsStructuresRepository $repo, int $idPermission, int $idStructure):Response
    {
        $entityManager = $doctrine->getManager();
        $permissionStructure = $repo->findOneBy(array("permissions" => $idPermission, "structures" => $idStructure))->setIsActive(true);
        $entityManager->flush($permissionStructure);

        return $this->redirectToRoute("app_manager");
    }

    #[Route("/manager/searchable/", name: "app_manager_searchable")]
    public function searchable(ManagerRegistry $doctrine, Request $request, UsersRepository $repository): Response
    {
        $id = $this->getUser()->getId();
        $user = $repository->find($id);

        // RECOVER ALL FILTERS
        $filterActiveUser = $request->get("activeUser");
        $filterInactiveUser = $request->get("inactiveUser");
        $filterPartner = $request->get("partner");
        $filterManager = $request->get("manager");
        $filterActiveStructure = $request->get("activeStructure");
        $filterInactiveStructure = $request->get("inactiveStructure");
        $filterStructure = $request->get("structure");

        $repositoryUser = $doctrine->getRepository(Users::class);
        $repositoryStructure = $doctrine->getRepository(Structures::class);
        $users = "";
        $structures = "";

        if ($filterActiveUser == true) {
            $users = $repositoryUser->getActiveUsers();
        } elseif ($filterInactiveUser == true) {
            $users = $repositoryUser->getInactiveUsers();
        } elseif ($filterPartner == true) {
            $users = $repositoryUser->findByRole('"ROLE_PARTNER"');
        } elseif ($filterManager == true) {
            $users = $repositoryUser->findByRole("[]");
        } elseif ($filterActiveStructure == true) {
            $structures = $repositoryStructure->getActiveStructures();
        } elseif ($filterInactiveStructure == true) {
            $structures = $repositoryStructure->getInactiveStructures();
        } elseif ($filterStructure == true) {
            $structures = $repositoryStructure->findAll();
        } else {
            $users = $repositoryUser->findAll();
            $structures = $repositoryStructure->findAll();
        }

        if ($request->get("ajax")){
            return new JsonResponse([
                "content" => $this->renderView("manager/_content.html.twig", [
                    "users" => $users,
                    "structures" => $structures
                ])
            ]);
        }

        return $this->render("manager/searchable.html.twig", [
            "users" => $users,
            "structures" => $structures,
            "user" => $user
        ]);
    }
}
