<?php

namespace App\Service;

use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class CustomerImporterService {

  public function __construct(
    private HttpClientInterface $customersClient, 
    private EntityManagerInterface $entityManager) {
  }

  public function fetchCustomers ($params = []) {
    $response = $this->customersClient->request('GET', '/api', [
      'query' => $params
    ])->toArray();

    return $response['results'];
  }

  public function importCustomers ($params = []) {
    $customers = array_map(function($customer) {
      return [
        'first_name' => $customer['name']['first'],
        'last_name' => $customer['name']['last'],
        'email' => $customer['email'],
        'username' => $customer['login']['username'],
        'password' => $customer['login']['password'],
        'gender' => $customer['gender'],
        'country' => $customer['location']['country'],
        'city' => $customer['location']['city'],
        'phone' => $customer['phone']
      ];
    }, $this->fetchCustomers($params));

    foreach ($customers as $customer) {
      $this->getRepository()->createCustomer($customer);
    }

    return count($customers);
  }

  public function deleteAllCustomers() {
    $this->getRepository()->deleteAllCustomers();
  }

  private function getRepository() {
    return $this->entityManager->getRepository(Customer::class);
  }
}