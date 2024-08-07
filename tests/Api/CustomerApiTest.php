<?php

namespace App\Tests\Api;

use App\Tests\DatabaseTestCase;


class CustomerApiTest extends DatabaseTestCase
{
    public function testEmptyCustomers()
    {
        $this->deleteCustomers();
        
        // Make the request
        $this->client->request('GET', '/customers');

        $response = $this->client->getResponse();

        // Assert the status code is 200
        $this->assertEquals(200, $response->getStatusCode());

        $content = $response->getContent();

        // Assert the response is not empty
        $this->assertNotEmpty($content);

        // Assert the json structure
        $this->assertJson($content);

        // Assert the response contains the expected keys
        $responseData = json_decode($content, true);

        $this->assertEmpty($responseData);
    }

    public function testFetchAllCustomers()
    {
        $this->createCustomers();

        // Make the request
        $this->client->request('GET', '/customers');

        $response = $this->client->getResponse();

        // Assert the status code is 200
        $this->assertEquals(200, $response->getStatusCode());

        $content = $response->getContent();

        // Assert the response is not empty
        $this->assertNotEmpty($content);

        // Assert the json structure
        $this->assertJson($content);

        // Assert the response contains the expected keys
        $responseData = json_decode($content, true);

        foreach ($responseData as $customer) {
            $this->assertArrayHasKey('full_name', $customer);
            $this->assertArrayHasKey('email', $customer);
            $this->assertArrayHasKey('country', $customer);
        }
    }

    public function testFindCustomer () {
        $this->deleteCustomers();
        $this->createCustomer([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@email.com',
            'username' => 'johndoe',
            'password' => md5('password123'),
            'gender' => 'male',
            'country' => 'Australia',
            'city' => 'Sydney',
            'phone' => '123-456-7890',
        ]);

        // Make the request
        $this->client->request('GET', '/customers/1');

        $response = $this->client->getResponse();

        // Assert the status code is 200
        $this->assertEquals(200, $response->getStatusCode());

        $content = $response->getContent();

        // Assert the response is not empty
        $this->assertNotEmpty($content);

        // Assert the json structure
        $this->assertJson($content);

        // Assert the response contains the expected keys
        $responseData = json_decode($content, true);

        $this->assertArrayHasKey('full_name', $responseData);
        $this->assertArrayHasKey('email', $responseData);
        $this->assertArrayHasKey('username', $responseData);
        $this->assertArrayHasKey('country', $responseData);
        $this->assertArrayHasKey('gender', $responseData);
        $this->assertArrayHasKey('city', $responseData);
        $this->assertArrayHasKey('phone', $responseData);
    }

    public function testFailedFindingCustomerById() {
        $this->deleteCustomers();

        // Make the request
        $this->client->request('GET', '/customers/999');

        $response = $this->client->getResponse();

        // Assert the status code is 404
        $this->assertEquals(404, $response->getStatusCode());

        $content = $response->getContent();

        // Assert the response is not empty
        $this->assertNotEmpty($content);

        // Assert the json structure
        $this->assertJson($content);

        // Assert the response contains the expected keys
        $this->assertEquals('Customer not found', json_decode($content, true)['error']);
    }
}
