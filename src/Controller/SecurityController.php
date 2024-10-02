<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: "/", name: "app_login")]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if (
            $this->getUser()
            && $this->container->get("security.authorization_checker")->isGranted("ROLE_ADMIN") 
            && $this->getUser()->isIsActive() == true
        ) {
            return $this->redirectToRoute("app_admin");
        } 
        elseif (
            $this->getUser() 
            && $this->container->get("security.authorization_checker")->isGranted("ROLE_PARTNER") 
            && $this->getUser()->isIsActive() == true
        ) {
            return $this->redirectToRoute("app_partner");
        } 
        elseif (
            $this->getUser() 
            && $this->container->get("security.authorization_checker")->isGranted("ROLE_MANAGER") 
            && $this->getUser()->isIsActive() == true
        ) {
            return $this->redirectToRoute("app_manager");
        }
        elseif ($this->getUser() && $this->getUser()->isIsActive() == false) {
            $notice = "Votre compte n'est pas actif";
            return $this->redirectToRoute("app_logout", ["notice" => $notice]);
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render("security/login.html.twig", [
            "last_username" => $lastUsername, 
            "error" => $error
        ]);
    }

    #[Route(path: "/logout", name: "app_logout")]
    public function logout(): void
    {
        throw new \Exception('logout() should never be reached');
    }

    #[Route(path: "/CGU", name: "app_CGU")]
    public function legalNotices(UsersRepository $repository): Response
    {
        $id = $this->getUser()->getId();
        $user = $repository->find($id);

        return $this->render("security/mentionsCGU.html.twig", [
            "user" => $user
        ]);
    }
}
