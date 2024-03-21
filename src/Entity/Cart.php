<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Order $order = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]

    private ?User $user = null;

    #[ORM\OneToOne(mappedBy: 'cart', cascade: ['persist', 'remove'])]
    private ?Order $cart = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(Order $order): static
    {
        $this->order = $order;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCart(): ?Order
    {
        return $this->cart;
    }

    public function setCart(Order $cart): static
    {
        // set the owning side of the relation if necessary
        if ($cart->getCart() !== $this) {
            $cart->setCart($this);
        }

        $this->cart = $cart;

        return $this;
    }
}
