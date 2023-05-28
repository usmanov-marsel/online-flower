<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\FlowerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FlowerRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'flower:item']),
        new GetCollection(normalizationContext: ['groups' => 'flower:list']),
    ],
)]
class Flower
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['flower:list', 'flower:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['flower:list', 'flower:item'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['flower:list', 'flower:item'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['flower:list', 'flower:item'])]
    private ?int $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['flower:list', 'flower:item'])]
    private ?string $img = null;

    public function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

        return $this;
    }
}
