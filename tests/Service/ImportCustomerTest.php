<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\CustomerImporterService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class ImportCustomerTest extends TestCase
{
    private function mockService ($response) {
      $httpClient = new MockHttpClient([
        new MockResponse($response)
      ]);

      $mockEntityManager = $this->createMock(EntityManagerInterface::class);

      return new CustomerImporterService($httpClient, $mockEntityManager);
    }

    // Test Invalid Response Structure
    public function testImportCustomersEmptyResponse(): void
    {
      $testResponse = json_encode([
        'results' => [
        ]
      ]);

      $service = $this->mockService($testResponse);

      $response = $service->importCustomers();

      // Check if the response is empty
      $this->assertEquals($response, 0);
    }

    public function testImportCustomers(): void
    {
      $testResponse = json_encode([
        'results' => [
          [
              'name' => [
                'first' => 'John',
                'last' => 'Doe'
              ],
              'email' => 'john.doe@example.com',
              'login' => [
                'username' => 'johndoe',
                'password' => 'password123'
              ],
              'gender' => 'male',
              'location' => [
                'country' => 'Australia',
                'city' => 'Sydney'
              ],
              'phone' => '123-456-7890',
          ],
        ]
      ]);

      $service = $this->mockService($testResponse);

      $response = $service->importCustomers();

      $testCount = count(json_decode($testResponse, true)['results']);

      $this->assertEquals($response, $testCount);
    }
}
