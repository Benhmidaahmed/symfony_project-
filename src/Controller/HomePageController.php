<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Password\UserPasswordHasherInterface;

use App\Entity\User;

final class HomePageController extends AbstractController
{
    #[Route('/profile', name: 'app_home_page')]
    public function profile(): Response
    {
        // Vérifiez si l'utilisateur est connecté
        if ($this->getUser()) {
            // Si l'utilisateur est connecté et a le rôle ADMIN, redirigez-le
            if (in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
                return $this->redirectToRoute('app_admin_dashboard');
            }
        }

        // Affichez la page pour /profile
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }

    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        // Affichez la même page pour /
        return $this->render('home_page/index1.html.twig', [
            'controller_name' => 'HomePageController',
        ]);
    }
}