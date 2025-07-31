<?php

namespace App\Dto\Category;

readonly class UpdateCategoryDto
{
    public function __construct(

        private string $name,

        private string $slug,
    ){}

    public function getName(): string
    {
        return $this->name;
    }
    public function getSlug(): string
    {
        return $this->slug;
    }
}
