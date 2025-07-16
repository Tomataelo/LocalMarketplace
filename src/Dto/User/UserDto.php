<?php

namespace App\Dto\User;

use Symfony\Component\Validator\Constraints as Assert;

// to DTO służy tylko do create i get

readonly class UserDto
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
        private string $role,

        #[Assert\NotBlank]
        #[Assert\Regex("/^\+?[0-9]{1,4}?[-. ]?(\([0-9]{1,3}?\))?[-. ]?[0-9]+[-. ]?[0-9]+[-. ]?[0-9]+$/")]
        private string $phone_number,

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
}
