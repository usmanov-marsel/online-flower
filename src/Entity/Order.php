<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Dto\OrderDto;
use App\Processor\OrderProcessor;
use App\Repository\OrderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
#[ApiResource(
    operations: [
        new Post(processor: OrderProcessor::class),
    ],
    normalizationContext: ['groups' => ['order:read']],
    denormalizationContext: ['groups' => ['order:create']],
)]
//#[Post(input: OrderDto::class, processor: OrderProcessor::class)]
#[ORM\HasLifecycleCallbacks]
class Order
{
    #[ORM\Id]
    #[ORM\Column]
    private ?string $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['order:read'])]
    private ?\DateTimeInterface $orderDate = null;

    #[ORM\Column(length: 255)]
    #[Groups(['order:read'])]
    private ?string $status = null;

    #[ORM\Column]
    #[Groups(['order:read'])]
    private ?int $totalPrice = null;

    private ?string $name;

    #[ORM\ManyToOne(inversedBy: 'orders', cascade: ['persist'])]
    #[Groups(['order:read', 'order:create'])]
    private ?Cart $cart = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Client $client = null;

    public function __construct()
    {
        $this->orderDate = new \DateTimeImmutable();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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

    public function getName(): ?string
    {
        if ($this->id)
            return 'Заказ №' . $this->id . ' от ' . $this->orderDate->format('d-m-Y');
        else
            return 'nothing';
    }

    #[ORM\PrePersist]
    public function setOrderDateValue(): void
    {
        $this->orderDate = new \DateTimeImmutable();
        $this->status = "Не оплачено";
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
