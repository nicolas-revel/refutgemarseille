<?php

namespace App\Entity;

use App\Repository\OrderHasProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderHasProductRepository::class)
 */
class OrderHasProduct
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=order::class, inversedBy="product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_order;

    /**
     * @ORM\ManyToOne(targetEntity=product::class, inversedBy="orderHasProducts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $amount;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdOrder(): ?order
    {
        return $this->id_order;
    }

    public function setIdOrder(?order $id_order): self
    {
        $this->id_order = $id_order;

        return $this;
    }

    public function getProduct(): ?product
    {
        return $this->product;
    }

    public function setProduct(?product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
