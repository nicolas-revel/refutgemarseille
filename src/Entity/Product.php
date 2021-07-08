<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @Vich\Uploadable
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime")
     */
    private $releasedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="float", length=255)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image1;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image1")
     * @var File $image1File
     */
    private $image1File;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image2;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image2")
     * @var File $image2File
     */
    private $image2File;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image3;

    /**
     * @Vich\UploadableField(mapping="product_images", fileNameProperty="image3")
     * @var File $image3File
     */
    private $image3File;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="products")
     */
    private $tags;

    /**
     * @ORM\ManyToOne(targetEntity=Sale::class, inversedBy="orderHasProducts")
     */
    private $sale;

    /**
     * @ORM\ManyToMany(targetEntity=Cart::class, mappedBy="orderHasProducts")
     */
    private $carts;

    /**
     * @ORM\OneToMany(targetEntity=OrderHasProduct::class, mappedBy="product")
     */
    private $orderHasProducts;

    /**
     * @ORM\OneToMany(targetEntity=CartHasProduct::class, mappedBy="product")
     */
    private $cartHasProducts;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $stock;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->orderHasProducts = new ArrayCollection();
        $this->cartHasProducts = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getReleasedAt(): ?\DateTime
    {
        return $this->releasedAt;
    }

    public function setReleasedAt(\DateTime $releasedAt): self
    {
        $this->releasedAt = $releasedAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getImage1(): ?string
    {
        return $this->image1;
    }

    public function setImage1(?string $image1): self
    {
        $this->image1 = $image1;

        return $this;
    }

    public function getImage2(): ?string
    {
        return $this->image2;
    }

    public function setImage2(?string $image2): self
    {
        $this->image2 = $image2;

        return $this;
    }

    public function getImage3(): ?string
    {
        return $this->image3;
    }

    public function setImage3(?string $image3): self
    {
        $this->image3 = $image3;

        return $this;
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

    public function getCategory(): ?category
    {
        return $this->category;
    }

    public function setCategory(?category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    public function getSale(): ?Sale
    {
        return $this->sale;
    }

    public function setSale(?Sale $sale): self
    {
        $this->sale = $sale;

        return $this;
    }

    /**
     * @return Collection|OrderHasProduct[]
     */
    public function getOrderHasProducts(): Collection
    {
        return $this->orderHasProducts;
    }

    public function addOrderHasProduct(OrderHasProduct $orderHasProduct): self
    {
        if (!$this->orderHasProducts->contains($orderHasProduct)) {
            $this->orderHasProducts[] = $orderHasProduct;
            $orderHasProduct->setProduct($this);
        }

        return $this;
    }

    public function removeOrderHasProduct(OrderHasProduct $orderHasProduct): self
    {
        if ($this->orderHasProducts->removeElement($orderHasProduct)) {
            // set the owning side to null (unless already changed)
            if ($orderHasProduct->getProduct() === $this) {
                $orderHasProduct->setProduct(null);
            }
        }

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
            $cartHasProduct->setProduct($this);
        }

        return $this;
    }

    public function removeCartHasProduct(CartHasProduct $cartHasProduct): self
    {
        if ($this->cartHasProducts->removeElement($cartHasProduct)) {
            // set the owning side to null (unless already changed)
            if ($cartHasProduct->getProduct() === $this) {
                $cartHasProduct->setProduct(null);
            }
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return ?File
     */
    public function getImage1File (): ?File
    {
        return $this->image1File;
    }

    /**
     * @param File $image1File
     * @return Product
     */
    public function setImage1File (?File $image1File): Product
    {
        $this->image1File = $image1File;
        if ($image1File) {
            $this->updatedAt = new DateTime();
        }
        return $this;
    }

    /**
     * @return ?File
     */
    public function getImage2File (): ?File
    {
        return $this->image2File;
    }

    /**
     * @param File $image2File
     * @return Product
     */
    public function setImage2File (?File $image2File): Product
    {
        $this->image2File = $image2File;
        if ($image2File) {
            $this->updatedAt = new DateTime();
        }
        return $this;
    }

    /**
     * @return ?File
     */
    public function getImage3File (): ?File
    {
        return $this->image3File;
    }

    /**
     * @param File $image3File
     * @return Product
     */
    public function setImage3File (?File $image3File): Product
    {
        $this->image3File = $image3File;
        if ($image3File) {
            $this->updatedAt = new DateTime();
        }
        return $this;
    }

    public function __toString ()
    {
        return $this->getName();
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }
}
