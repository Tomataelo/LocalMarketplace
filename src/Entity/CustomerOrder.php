<?php

namespace App\Entity;

use App\Repository\CustomerOrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerOrderRepository::class)]
#[ORM\Index(name: "idx_client_id", columns: ["client_id"])]
class CustomerOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: "client_id", referencedColumnName: "id")]
    private ?User $client = null;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(name: "category_id", referencedColumnName: "id")]
    private ?Category $category = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $preferred_date = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 15)]
    private ?string $postal_code = null;

    #[ORM\ManyToOne(targetEntity: Province::class)]
    #[ORM\JoinColumn(name: "province_id", referencedColumnName: "id")]
    private ?Province $province = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): User
    {
        return $this->client;
    }

    public function setClient(User $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPreferredDate(): ?\DateTimeImmutable
    {
        return $this->preferred_date;
    }

    public function setPreferredDate(\DateTimeImmutable $preferred_date): static
    {
        $this->preferred_date = $preferred_date;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): static
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getProvince(): ?Province
    {
        return $this->province;
    }

    public function setProvince(Province $province): static
    {
        $this->province = $province;

        return $this;
    }
}
