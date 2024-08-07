<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\DBAL\Schema\Table;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ORM\Table(name: 'customers')]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // First name
    #[ORM\Column(length: 255)]
    private ?string $first_name = null;

    // Last name
    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    // Email
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    // Username
    #[ORM\Column(length: 255)]
    private ?string $username = null;

    // Password
    #[ORM\Column(length: 255)]
    private ?string $password = null;

    // Gender
    #[ORM\Column(length: 255)]
    private ?string $gender = null;

    // Country
    #[ORM\Column(length: 255)]
    private ?string $country = null;

    // City
    #[ORM\Column(length: 255)]
    private ?string $city = null;

    // Phone
    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName (): string {
      return $this->first_name . ' ' . $this->last_name;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = md5($password);

        return $this;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    
}
