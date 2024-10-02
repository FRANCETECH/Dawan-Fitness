<?php

namespace App\Controller;

use App\Repository\PermissionsStructuresRepository;
use App\Repository\PermissionsUsersRepository;
use App\Repository\StructuresRepository;
use App\Repository\UsersRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartnerController extends AbstractController
{
    #[Route("/partner", name: "app_partner")]
    public function partnerHome(UsersRepository $repository): Response
    {
        $id = $this->getUser()->getId();
        $user = $repository->find($id);
        return $this->render("partner/partnerHome.html.twig", [
            "user" => $user
        ]);
    }
    #[Route("/partner/disable/permission/{idPermission}", name: "disable_permission_partner")]
    public function disablePermission(ManagerRegistry $doctrine, PermissionsUsersRepository $repo, int $idPermission): Response
    {
        $entityManager = $doctrine->getManager();
        $id = $this->getUser()->getId();
    
        // Trouver l'utilisateur ayant cette permission et désactiver la permission
        $permissionUser = $repo->findOneBy(array("Permissions" => $idPermission, "users" => $id));
        if ($permissionUser) {
            $permissionUser->setIsActive(false);
    
            // Pas besoin de flush() avec un argument, juste le flush() global
            $entityManager->flush();
        }
    
        return $this->redirectToRoute("app_partner");
    }
    

    #[Route("/partner/enable/permission/{idPermission}", name: "enable_permission_partner")]
    public function enablePermission(ManagerRegistry $doctrine, PermissionsUsersRepository $repo, int $idPermission): Response
    {
        $entityManager = $doctrine->getManager();
        $id = $this->getUser()->getId();
    
        // Trouver l'utilisateur ayant cette permission et activer la permission
        $permissionUser = $repo->findOneBy(array("Permissions" => $idPermission, "users" => $id));
    
        if ($permissionUser) {
            $permissionUser->setIsActive(true);
    
            // Appel à flush() sans argument
            $entityManager->flush();
        }
    
        return $this->redirectToRoute("app_partner");
    }
    

    #[Route("/partner/disable/structure/{idStructure}", name: "disable_structure_partner")]
    public function disableStructure(ManagerRegistry $doctrine, StructuresRepository $repo, int $idStructure): Response
    {
        $entityManager = $doctrine->getManager();
        
        // Trouver la structure par ID et désactiver
        $structure = $repo->find($idStructure);
    
        if ($structure) {
            $structure->setIsActive(false);
    
            // Appel à flush() sans argument
            $entityManager->flush();
        }
    
        return $this->redirectToRoute("app_partner");
    }
    

    #[Route("/partner/enable/structure/{idStructure}", name: "enable_structure_partner")]
    public function enableStructure(ManagerRegistry $doctrine, StructuresRepository $repo, int $idStructure): Response
    {
        $entityManager = $doctrine->getManager();
        
        // Trouver la structure par ID et activer
        $structure = $repo->find($idStructure);
    
        if ($structure) {
            $structure->setIsActive(true);
    
            // Appel à flush() sans argument
            $entityManager->flush();
        }
    
        return $this->redirectToRoute("app_partner");
    }
    

    #[Route("/partner/disable/permission/structure/{idPermission}/{idStructure}", name: "disable_permission_structure_partner")]
    public function disablePermissionStructure(ManagerRegistry $doctrine, PermissionsStructuresRepository $repo, int $idPermission, int $idStructure): Response
    {
        $entityManager = $doctrine->getManager();
        
        // Trouver la permission de la structure par ID
        $permissionStructure = $repo->findOneBy(array("permissions" => $idPermission, "structures" => $idStructure));
    
        if ($permissionStructure) {
            $permissionStructure->setIsActive(false);
    
            // Appel à flush() sans argument
            $entityManager->flush();
        }
    
        return $this->redirectToRoute("app_partner");
    }
    

    #[Route("/partner/enable/permission/structure/{idPermission}/{idStructure}", name: "enable_permission_structure_partner")]
    public function enablePermissionStructure(ManagerRegistry $doctrine, PermissionsStructuresRepository $repo, int $idPermission, int $idStructure): Response
    {
        $entityManager = $doctrine->getManager();
        
        // Trouver la permission de la structure par ID
        $permissionStructure = $repo->findOneBy(array("permissions" => $idPermission, "structures" => $idStructure));
    
        if ($permissionStructure) {
            $permissionStructure->setIsActive(true);
    
            // Appel à flush() sans argument
            $entityManager->flush();
        }
    
        return $this->redirectToRoute("app_partner");
    }
    
}
