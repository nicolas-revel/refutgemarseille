<?php

namespace App\Entity;

use App\Repository\CartRepository;
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
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=user::class, inversedBy="cart", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $totatAmount;

    /**
     * @ORM\OneToMany(targetEntity=CartHasProduct::class, mappedBy="cart")
     */
    private $cartHasProducts;

    public function __construct()
    {
        $this->cartHasProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(user $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTotatAmount(): ?string
    {
        return $this->totatAmount;
    }

    public function setTotatAmount(string $totatAmount): self
    {
        $this->totatAmount = $totatAmount;

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
}
