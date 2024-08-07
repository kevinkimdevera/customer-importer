<?php

namespace App\Tests;

use App\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DatabaseTestCase extends WebTestCase
{
    protected $entityManager;

    protected $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
    }

    public function createCustomer ($data) {
      $customer = new Customer();
      $customer->setFirstName($data['first_name']);
      $customer->setLastName($data['last_name']);
      $customer->setEmail($data['email']);
      $customer->setUsername($data['username']);
      $customer->setPassword($data['password']);
      $customer->setGender($data['gender']);
      $customer->setCountry($data['country']);
      $customer->setCity($data['city']);
      $customer->setPhone($data['phone']);

      $this->entityManager->persist($customer);
      $this->entityManager->flush();
    }

    public function createCustomers () {
      // Create customers
      $customers = [
          [
              'first_name' => 'John',
              'last_name' => 'Doe',
              'email' => 'john.doe@email.com',
              'username' => 'johndoe',
              'password' => md5('password123'),
              'gender' => 'male',
              'country' => 'Australia',
              'city' => 'Sydney',
              'phone' => '123-456-7890',
          ],
          [
              'first_name' => 'Jane',
              'last_name' => 'Doe',
              'email' => 'jane.doe@email.com',
              'username' => 'janedoe',
              'password' => md5('password123'),
              'gender' => 'female',
              'country' => 'Australia',
              'city' => 'Sydney',
              'phone' => '123-456-7890',
          ],
      ];

      foreach ($customers as $c) {
          $this->createCustomer($c);
      }
    }

    public function deleteCustomers () {
      $this->entityManager->getRepository(Customer::class)->deleteAllCustomers();
    }
}