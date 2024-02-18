<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\OneToMany(targetEntity: CustomerAddress::class, mappedBy: 'id_')]
    private Collection $customerAddresses;

    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'id_')]
    private Collection $orders_id;

    public function __construct()
    {
        $this->customerAddresses = new ArrayCollection();
        $this->orders_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection<int, CustomerAddress>
     */
    public function getCustomerAddresses(): Collection
    {
        return $this->customerAddresses;
    }

    public function addCustomerAddress(CustomerAddress $customerAddress): static
    {
        if (!$this->customerAddresses->contains($customerAddress)) {
            $this->customerAddresses->add($customerAddress);
            $customerAddress->setId($this);
        }

        return $this;
    }

    public function removeCustomerAddress(CustomerAddress $customerAddress): static
    {
        if ($this->customerAddresses->removeElement($customerAddress)) {
            // set the owning side to null (unless already changed)
            if ($customerAddress->getId() === $this) {
                $customerAddress->setId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrdersId(): Collection
    {
        return $this->orders_id;
    }

    public function addOrdersId(Order $ordersId): static
    {
        if (!$this->orders_id->contains($ordersId)) {
            $this->orders_id->add($ordersId);
            $ordersId->setId($this);
        }

        return $this;
    }

    public function removeOrdersId(Order $ordersId): static
    {
        if ($this->orders_id->removeElement($ordersId)) {
            // set the owning side to null (unless already changed)
            if ($ordersId->getId() === $this) {
                $ordersId->setId(null);
            }
        }

        return $this;
    }
}
