<?php

namespace App\Dto;

class UserDto
{
    public function __construct(
        public string $email,

        public string $password,

        public string $first_name,

        public string $last_name,

        public string $role,

        public string $phone_number,
    ) {}
}
