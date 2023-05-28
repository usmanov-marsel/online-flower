<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\BouquetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BouquetRepository::class)]
#[Get(normalizationContext: ['groups' => 'bouquet:read'])]
#[GetCollection(normalizationContext: ['groups' => 'bouquet:list'])]
class Bouquet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['bouquet:list', 'bouquet:read'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['bouquet:list', 'bouquet:read'])]
    private ?int $totalPrice = null;

    #[ORM\OneToMany(mappedBy: 'bouquet', targetEntity: FlowerItem::class, cascade: ['persist'])]
    private Collection $flowerItems;

    #[ORM\ManyToOne(inversedBy: 'bouquets')]
    private ?Package $package = null;

    #[ORM\ManyToOne(inversedBy: 'bouquets')]
    private ?Decoration $decoration = null;

    public function __construct()
    {
        $this->flowerItems = new ArrayCollection();
    }

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

    public function getTotalPrice(): ?int
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(int $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * @return Collection<int, FlowerItem>
     */
    public function getFlowerItems(): Collection
    {
        return $this->flowerItems;
    }

    public function addFlowerItem(FlowerItem $flowerItem): self
    {
        if (!$this->flowerItems->contains($flowerItem)) {
            $this->flowerItems->add($flowerItem);
            $flowerItem->setBouquet($this);
        }

        return $this;
    }

    public function removeFlowerItem(FlowerItem $flowerItem): self
    {
        if ($this->flowerItems->removeElement($flowerItem)) {
            // set the owning side to null (unless already changed)
            if ($flowerItem->getBouquet() === $this) {
                $flowerItem->setBouquet(null);
            }
        }

        return $this;
    }

    public function getPackage(): ?Package
    {
        return $this->package;
    }

    public function setPackage(?Package $package): self
    {
        $this->package = $package;

        return $this;
    }

    public function getDecoration(): ?Decoration
    {
        return $this->decoration;
    }

    public function setDecoration(?Decoration $decoration): self
    {
        $this->decoration = $decoration;

        return $this;
    }
}
