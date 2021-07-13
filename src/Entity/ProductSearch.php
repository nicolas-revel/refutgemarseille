<?php


namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class ProductSearch
{

    /**
     * @var string|null
     */
    private ?string $query;

    /**
     * @var bool|null
     */
    private ?bool $preorder;

    /**
     * @var bool|null
     */
    private ?bool $sale;

    /**
     * @var ArrayCollection|null
     */
    private ?ArrayCollection $categories = null;

    /**
     * @var ArrayCollection|null
     */
    private ?ArrayCollection $tags = null;

    public function __construct ()
    {
        $this->query = null;
        $this->preorder = null;
        $this->sale = null;
        $this->categories = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getQuery (): ?string
    {
        return $this->query;
    }

    /**
     * @param string|null $query
     * @return ProductSearch
     */
    public function setQuery (?string $query): ProductSearch
    {
        $this->query = $query;
        return $this;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getCategories (): ?ArrayCollection
    {
        return $this->categories;
    }

    /**
     * @param ArrayCollection|null $categories
     */
    public function setCategories (?ArrayCollection $categories): void
    {
        $this->categories = $categories;
    }

    /**
     * @return ArrayCollection|null
     */
    public function getTags (): ?ArrayCollection
    {
        return $this->tags;
    }

    /**
     * @param ArrayCollection|null $tags
     */
    public function setTags (?ArrayCollection $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return bool|null
     */
    public function getPreorder (): ?bool
    {
        return $this->preorder;
    }

    /**
     * @param bool|null $preorder
     * @return ProductSearch
     */
    public function setPreorder (?bool $preorder): ProductSearch
    {
        $this->preorder = $preorder;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getSale (): ?bool
    {
        return $this->sale;
    }

    /**
     * @param bool|null $sale
     * @return ProductSearch
     */
    public function setSale (?bool $sale): ProductSearch
    {
        $this->sale = $sale;
        return $this;
    }

}