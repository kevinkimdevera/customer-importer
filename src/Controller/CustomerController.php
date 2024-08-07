<?php

namespace App\Controller;

use App\Service\CustomerManagerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

class CustomerController extends AbstractController
{
    public function __construct(
        private CustomerManagerService $customerManager
    ) {
    }

    #[Route('/customers', name: 'app_customer', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        // Default parameters
        $params = [
            'search' => $request->query->get('search')
        ];

        // Get all customers from CustomerManagerService
        $customers = $this->customerManager->getCustomers($params);

        return $this->json($customers);
    }


    #[Route('/customers/{customerId}', name: 'app_customer_show', methods: ['GET'])]
    public function show ($customerId): JsonResponse
    {
        $customer = $this->customerManager->getCustomer($customerId);

        if (!$customer) {
            return $this->json(['error' => 'Customer not found'], 404);
        }

        return $this->json($customer);
    }
}
