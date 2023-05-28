<?php

namespace App\Entity;

use App\Repository\FlowerItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FlowerItemRepository::class)]
class FlowerItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'flowerItems')]
    private ?Flower $flower = null;

    #[ORM\Column]
    private ?int $count = null;

    #[ORM\ManyToOne(inversedBy: 'flowerItems')]
    private ?Bouquet $bouquet = null;

    public function __toString(): string
    {
        return $this->flower->getName() . ' ' . $this->count;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFlower(): ?Flower
    {
        return $this->flower;
    }

    public function setFlower(Flower $flower): self
    {
        $this->flower = $flower;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getBouquet(): ?Bouquet
    {
        return $this->bouquet;
    }

    public function setBouquet(?Bouquet $bouquet): self
    {
        $this->bouquet = $bouquet;

        return $this;
    }
}
