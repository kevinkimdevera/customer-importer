<?php

namespace App\Repository;

use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Customer>
 */
class CustomerRepository extends ServiceEntityRepository
{
    protected $_em;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);

        $this->_em = $this->getEntityManager();
    }
    
    // Check if Customer Exists by Email
    private function checkByEmail ($email) {
        return $this->findOneBy(['email' => $email]);
    }

    private function _save ($customer, $data) {
      $customer->setFirstName($data['first_name']);
      $customer->setLastName($data['last_name']);
      $customer->setEmail($data['email']);
      $customer->setUsername($data['username']);
      $customer->setPassword($data['password']);
      $customer->setGender($data['gender']);
      $customer->setCountry($data['country']);
      $customer->setCity($data['city']);
      $customer->setPhone($data['phone']);

      $this->_em->persist($customer);
      $this->_em->flush();

      return $customer;
    }

    // Get All Customers
    public function getAllCustomers($params = [])
    {
      $search = $params['search'] ?? null;

      $qb = $this->createQueryBuilder('c');

      $qb->select('c')
         ->orderBy('c.id', 'ASC');

      if ($search) {
        $qb->andWhere('c.first_name LIKE :search')
           ->orWhere('c.last_name LIKE :search')
           ->orWhere('c.email LIKE :search')
           ->setParameter('search', "%$search%");
      }

      $query = $qb->getQuery();

      return $query->execute();
    }

    // Find Customer by ID
    public function findCustomerById($customerId)
    {
      return $this->find($customerId);
    }

    // Create Customer
    public function createCustomer($data)
    {
      // If the data provider returns customer that already exist by email - Update the customer.
      $customer = $this->checkByEmail($data['email']);

      if (!$customer) {
        $customer = new Customer();
      }

      return $this->_save($customer, $data);
    }

    // Delete All Customers
    public function deleteAllCustomers()
    {
        // Truncate the table
        $this->_em->getConnection()->executeStatement('TRUNCATE TABLE customers');
    }

}
