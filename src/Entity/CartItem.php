<?php

namespace App\Entity;

use App\Repository\CartItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartItemRepository::class)]
class CartItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cartItems', cascade: ['persist'])]
    private ?Bouquet $bouquet = null;

    #[ORM\Column]
    private ?int $count = null;


    public function __construct()
    {
    }

    public function __toString()
    {
        if ($this->bouquet)
            return $this->bouquet->getName();
        return 'Букет ?';
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }
}
