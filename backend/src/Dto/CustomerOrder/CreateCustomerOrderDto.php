<?php

namespace App\Dto\CustomerOrder;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateCustomerOrderDto
{
    public function __construct(

        #[Assert\NotBlank]
        #[Assert\Positive]
        private int $client_id,

        #[Assert\NotBlank]
        #[Assert\Positive]
        private int $category_id,

        #[Assert\NotBlank]
        private string $title,

        #[Assert\NotBlank]
        #[Assert\Length(min: 5, max: 255, minMessage: "The title is too short.", maxMessage: "The title cannot exceed 255 characters.")]
        private string $description,

        #[Assert\NotBlank]
        #[Assert\Type(\DateTimeImmutable::class)]
        #[Assert\GreaterThan("today", message: "Preferred date must be in the future.")]
        private \DateTimeImmutable $preferred_date,

        #[Assert\NotBlank]
        private string $city,

        #[Assert\NotBlank]
        private string $address,

        #[Assert\NotBlank]
        #[Assert\Regex(pattern: "/^\d{2}-\d{3}$/", message: "Kod pocztowy powinien być w formacie 00-000.")]
        private string $postal_code,

        #[Assert\NotBlank]
        private int $province_id
    ){}

    public function getClientId(): int
    {
        return $this->client_id;
    }

    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPreferredDate(): \DateTimeImmutable
    {
        return $this->preferred_date;
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

    public function getProvinceId(): int
    {
        return $this->province_id;
    }
}
