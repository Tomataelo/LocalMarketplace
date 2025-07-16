<?php

namespace App\Dto\User;

use Symfony\Component\Validator\Constraints as Assert;

// to DTO służy tylko do update'tu

readonly class UpdateUserDto
{
    public function __construct(

        #[Assert\Email]
        private ?string $email = null,

        #[Assert\Length(min: 6)]
        private ?string $password = null,

        private ?string $first_name = null,

        private ?string $last_name = null,

        private ?string $role = null,

        #[Assert\Regex("/^\+?[0-9]{1,4}?[-. ]?(\([0-9]{1,3}?\))?[-. ]?[0-9]+[-. ]?[0-9]+[-. ]?[0-9]+$/")]
        private ?string $phone_number = null,

    )
    {}

    public function getEmail(): string|null
    {
        return $this->email;
    }

    public function getPassword(): string|null
    {
        return $this->password;
    }

    public function getFirstName(): string|null
    {
        return $this->first_name;
    }

    public function getLastName(): string|null
    {
        return $this->last_name;
    }

    public function getRole(): string|null
    {
        return $this->role;
    }

    public function getPhoneNumber(): string|null
    {
        return $this->phone_number;
    }
}
