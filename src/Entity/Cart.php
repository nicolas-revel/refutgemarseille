<?php

namespace App\Entity;

use App\Repository\CartRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 */
class Cart
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTime $createdAt;

    /**
     * @ORM\Column(type="float", length=255, nullable=true)
     */
    private ?float $totalAmount;

    /**
     * @ORM\OneToMany(targetEntity=CartHasProduct::class, mappedBy="cart", orphanRemoval=true)
     */
    private $cartHasProducts;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="cart", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->cartHasProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTotalAmount(): ?float
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(float $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * @return Collection|CartHasProduct[]
     */
    public function getCartHasProducts(): Collection
    {
        return $this->cartHasProducts;
    }

    public function addCartHasProduct(CartHasProduct $cartHasProduct): self
    {
        if (!$this->cartHasProducts->contains($cartHasProduct)) {
            $this->cartHasProducts[] = $cartHasProduct;
            $cartHasProduct->setCart($this);
        }

        return $this;
    }

    public function removeCartHasProduct(CartHasProduct $cartHasProduct): self
    {
        if ($this->cartHasProducts->removeElement($cartHasProduct)) {
            // set the owning side to null (unless already changed)
            if ($cartHasProduct->getCart() === $this) {
                $cartHasProduct->setCart(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
