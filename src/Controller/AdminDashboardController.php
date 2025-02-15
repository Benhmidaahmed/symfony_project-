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
    $appointments = $appointmentRepository->findAll();
    $users = $userRepository->findAll();

    // Nombre total de rendez-vous
    $appointmentCount = $appointmentRepository->count([]);

    // Nombre total d'utilisateurs
    $userCount = $userRepository->count([]);

    // Récupérer la date du jour à 00:00:00 et 23:59:59
    $today = new \DateTime();
    $today->setTime(0, 0, 0);
    $endOfDay = new \DateTime();
    $endOfDay->setTime(23, 59, 59);

    // Nombre de rendez-vous du jour
    $todayAppointments = $appointmentRepository->createQueryBuilder('a')
        ->select('COUNT(a.id)')
        ->where('a.date BETWEEN :start AND :end')
        ->setParameter('start', $today)
        ->setParameter('end', $endOfDay)
        ->getQuery()
        ->getSingleScalarResult();

    // Nombre de rendez-vous en attente (si "en attente" signifie que le champ commentaire est NULL)
    $pendingAppointments = $appointmentRepository->createQueryBuilder('a')
    ->select('COUNT(a.id)')
    ->where('a.adminComment IS NULL')
    ->getQuery()
    ->getSingleScalarResult();

    return $this->render('admin_dashboard/index.html.twig', [
        'appointments' => $appointments,
        'users' => $users,
        'appointmentCount' => $appointmentCount,
        'userCount' => $userCount,
        'todayAppointments' => $todayAppointments,
        'pendingAppointments' => $pendingAppointments
    ]);
}

    
}
