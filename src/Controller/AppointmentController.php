<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Form\AppointmentType;
use App\Repository\AppointmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;


#[Route('/appointment')]
final class AppointmentController extends AbstractController
{
    private function getLayout(): string
    {
        return $this->isGranted('ROLE_ADMIN') ? 'Layout/base_admin.html.twig' : 'Layout/base.html.twig';
    }

    #[Route(name: 'app_appointment_index', methods: ['GET'])]
public function index(AppointmentRepository $appointmentRepository): Response
{
    if ($this->isGranted('ROLE_ADMIN')) {
        // Récupérer tous les rendez-vous si l'utilisateur est admin
        $appointments = $appointmentRepository->findAll();
    } else {
        // Récupérer uniquement les rendez-vous de l'utilisateur connecté
        $user = $this->getUser();
        $appointments = $appointmentRepository->findBy(['user' => $user]);
    }

    return $this->render('appointment/index.html.twig', [
        'appointments' => $appointments,
        'layout' => $this->getLayout(),
    ]);
}



    // #[Route('/new', name: 'app_appointment_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $user = $this->getUser();
    //     if (!$user) {
    //         $this->addFlash('error', 'Vous devez être connecté pour prendre un rendez-vous.');
    //         return $this->redirectToRoute('app_login'); // Rediriger vers la page de connexion
    //     }
    //     $appointment = new Appointment();
    //     $form = $this->createForm(AppointmentType::class, $appointment);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($appointment);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_appointment_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('appointment/new.html.twig', [
    //         'appointment' => $appointment,
    //         'form' => $form,
    //         'layout' => $this->getLayout(),
    //     ]);
    // }
    // src/Controller/AppointmentController.php

#[Route('/new', name: 'app_appointment_new', methods: ['GET', 'POST'])]
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $user = $this->getUser();  // Récupérer l'utilisateur connecté
    if (!$user) {
        $this->addFlash('error', 'Vous devez être connecté pour prendre un rendez-vous.');
        return $this->redirectToRoute('app_login');
    }

    $appointment = new Appointment();
    $appointment->setUser($user);  // Assigner l'utilisateur connecté au rendez-vous

    $form = $this->createForm(AppointmentType::class, $appointment);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->persist($appointment);
        $entityManager->flush();

        return $this->redirectToRoute('app_appointment_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('appointment/new.html.twig', [
        'appointment' => $appointment,
        'form' => $form,
        'layout' => $this->getLayout(),
    ]);
}


    #[Route('/{id}', name: 'app_appointment_show', methods: ['GET'])]
    public function show(Appointment $appointment): Response
    {
        return $this->render('appointment/show.html.twig', [
            'appointment' => $appointment,
            'layout' => $this->getLayout(),
        ]);
    }


    #[Route('/{id}/edit', name: 'app_appointment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Appointment $appointment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AppointmentType::class, $appointment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_appointment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('appointment/edit.html.twig', [
            'appointment' => $appointment,
            'form' => $form,
            'layout' => $this->getLayout(),
        ]);
    }

    #[Route('/{id}', name: 'app_appointment_delete', methods: ['POST'])]
    public function delete(Request $request, Appointment $appointment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$appointment->getId(), $request->get('_token'))) {
            $entityManager->remove($appointment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_appointment_index', [], Response::HTTP_SEE_OTHER);
    }
  
    #[Route('/appointments-data', name: 'app_appointment_data', methods: ['GET'])]

public function appointmentsData(AppointmentRepository $appointmentRepository): JsonResponse
{
    // Récupérer les rendez-vous
    $appointments = $appointmentRepository->findAll();

    // Convertir en format JSON
    $appointmentsData = [];
    foreach ($appointments as $appointment) {
        $appointmentsData[] = [
            'id' => $appointment->getId(),
            'client' => $appointment->getClient()->getName(), // Assure-toi que tu as une méthode getClient() et getName()
            'date' => $appointment->getDate()->format('Y-m-d H:i'),
            'status' => $appointment->getStatus(),
        ];
    }

    return new JsonResponse($appointmentsData);
}
#[Route('/partials/appointments', name: 'partials_appointments')]
public function appointmentsPartial(AppointmentRepository $appointmentRepository): Response
{
    $appointments = $appointmentRepository->findAll();

    return $this->render('partials/_appointments.html.twig', [
        'appointments' => $appointments,
    ]);
}


}
