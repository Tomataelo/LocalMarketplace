<?php

namespace App\Dto\Category;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CategoryDto
{
    public function __construct(

        #[Assert\NotBlank]
        private string $name,

        #[Assert\NotBlank]
        private string $description,
    ){}

    public function getName(): string
    {
        return $this->name;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
}
