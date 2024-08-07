<?php

namespace App\Service;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;

class CustomerManagerService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    private function getRepository() {
      return $this->entityManager->getRepository(Customer::class);
    }

    public function getCustomers($params = [])
    {
        $customers = $this->getRepository()->getAllCustomers($params);

        return array_map(function($customer) {
          return [
            'full_name' => $customer->getFullName(),
            'email' => $customer->getEmail(),
            'country' => $customer->getCountry(),
          ];
        }, $customers);
    }

    public function getCustomer($customerId)
    {
        if ($customer = $this->getRepository()->findCustomerById($customerId)) {
          return [
            'full_name' => $customer->getFullName(),
            'email' => $customer->getEmail(),
            'username' => $customer->getUsername(),
            'country' => $customer->getCountry(),
            'gender' => $customer->getGender(),
            'city' => $customer->getCity(),
            'phone' => $customer->getPhone(),
          ];
        }

        return null;
    }

}