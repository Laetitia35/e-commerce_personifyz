<?php

namespace App\Entity;

use App\Repository\ColorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ColorRepository::class)]
class Color
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $codeHexadecimal = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    /**
     * @var Collection<int, OptionValue>
     */
    #[ORM\ManyToMany(targetEntity: OptionValue::class, inversedBy: 'colors')]
    private Collection $optionValue;

    /**
     * @var Collection<int, Product>
     */
    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'colors')]
    private Collection $products;

    public function __construct()
    {
        $this->optionValue = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeHexadecimal(): ?string
    {
        return $this->codeHexadecimal;
    }

    public function setCodeHexadecimal(string $codeHexadecimal): static
    {
        $this->codeHexadecimal = $codeHexadecimal;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, OptionValue>
     */
    public function getOptionValue(): Collection
    {
        return $this->optionValue;
    }

    public function addOptionValue(OptionValue $optionValue): static
    {
        if (!$this->optionValue->contains($optionValue)) {
            $this->optionValue->add($optionValue);
        }

        return $this;
    }

    public function removeOptionValue(OptionValue $optionValue): static
    {
        $this->optionValue->removeElement($optionValue);

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        $this->products->removeElement($product);

        return $this;
    }
}
