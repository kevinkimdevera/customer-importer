<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
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

        foreach ($customers as $cstmr) {
            $customer = new Customer();
            $customer->setFirstName($cstmr['first_name']);
            $customer->setLastName($cstmr['last_name']);
            $customer->setEmail($cstmr['email']);
            $customer->setUsername($cstmr['username']);
            $customer->setPassword($cstmr['password']);
            $customer->setGender($cstmr['gender']);
            $customer->setCountry($cstmr['country']);
            $customer->setCity($cstmr['city']);
            $customer->setPhone($cstmr['phone']);

            $manager->persist($customer);
            $manager->flush();
        }
    }
}
