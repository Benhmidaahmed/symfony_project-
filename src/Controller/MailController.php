<?php

namespace App\Controller;

use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    #[Route('/send-email', name: 'send_email')]
    public function sendEmail(MailerService $mailerService): Response
    {
        $mailerService->sendEmail(
            'bo7midbenhmida@gmail.com',  // Remplace avec un vrai email
            'Bienvenue !',
            '<p>Merci de vous être inscrit sur notre plateforme.</p>'
        );

        return new Response('Email envoyé avec succès !');
    }
}
