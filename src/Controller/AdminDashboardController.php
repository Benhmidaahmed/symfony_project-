<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AppointmentRepository;
use App\Repository\UserRepository;

final class AdminDashboardController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'app_admin_dashboard')]
    public function index(AppointmentRepository $appointmentRepository, UserRepository $userRepository): Response
    {
        // Récupérer tous les rendez-vous
        $appointments = $appointmentRepository->findAll();

        // Récupérer les utilisateurs récents (par exemple les 10 derniers)
        $users = $userRepository->findAll();

        // Comptage des rendez-vous
        $appointmentCount = $appointmentRepository->count([]);

        // Comptage des utilisateurs
        $userCount = $userRepository->count([]);

        return $this->render('admin_dashboard/index.html.twig', [
            'appointments' => $appointments,
            'users' => $users,
            'appointmentCount' => $appointmentCount,
            'userCount' => $userCount,  // Passez le nombre d'utilisateurs
        ]);
    }
}
