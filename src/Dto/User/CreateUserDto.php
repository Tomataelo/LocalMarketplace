<?php

namespace App\Dto\User;

use Symfony\Component\Validator\Constraints as Assert;


readonly class CreateUserDto
{
    public function __construct(

        #[Assert\NotBlank]
        #[Assert\Email]
        private string $email,

        #[Assert\NotBlank]
        #[Assert\Length(min: 6)]
        private string $password,

        #[Assert\NotBlank]
        private string $first_name,

        #[Assert\NotBlank]
        private string $last_name,

        #[Assert\NotBlank]
        #[Assert\Choice(choices: ['client', 'contractor', 'admin'], message: 'Choose a valid role.')]
        private string $role,

        #[Assert\NotBlank]
        #[Assert\Regex("/^\+?[0-9]{1,4}?[-. ]?(\([0-9]{1,3}?\))?[-. ]?[0-9]+[-. ]?[0-9]+[-. ]?[0-9]+$/")]
        private string $phone_number,

        #[Assert\NotBlank]
        private string $city,

        #[Assert\NotBlank]
        private string $address,

        #[Assert\NotBlank]
        private string $postal_code,

        #[Assert\NotBlank]
        private string $province,
    ) {}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getPhoneNumber(): string
    {
        return $this->phone_number;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getPostalCode(): string
    {
        return $this->postal_code;
    }

    public function getProvince(): string
    {
        return $this->province;
    }

}
