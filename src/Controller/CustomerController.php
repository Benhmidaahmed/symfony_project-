<?php
// src/Controller/CustomerController.php
namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CustomerController extends AbstractController
{
    #[Route('/customers', name: 'app_customers', methods: ['GET'])]
    public function index(UserRepository $userRepository): JsonResponse
    {
        $customers = $userRepository->findAll();
        return $this->json($customers);
    }
    
}
