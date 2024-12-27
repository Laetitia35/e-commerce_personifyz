<?php

namespace App\Entity;

use App\Repository\OptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionRepository::class)]
#[ORM\Table(name: '`option`')]
class Option
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?float $additional_price = null;

    #[ORM\ManyToOne(inversedBy: 'options')]
    private ?Product $product = null;

    /**
     * @var Collection<int, OptionValue>
     */
    #[ORM\OneToMany(targetEntity: OptionValue::class, mappedBy: 'optiona')]
    private Collection $optionValues;

    public function __construct()
    {
        $this->optionValues = new ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->title ?? '';
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getAdditionalPrice(): ?float
    {
        return $this->additional_price;
    }

    public function setAdditionalPrice(?float $additional_price): static
    {
        $this->additional_price = $additional_price;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Collection<int, OptionValue>
     */
    public function getOptionValues(): Collection
    {
        return $this->optionValues;
    }

    public function addOptionValue(OptionValue $optionValue): static
    {
        if (!$this->optionValues->contains($optionValue)) {
            $this->optionValues->add($optionValue);
            $optionValue->setOptiona($this);
        }

        return $this;
    }

    public function removeOptionValue(OptionValue $optionValue): static
    {
        if ($this->optionValues->removeElement($optionValue)) {
            // set the owning side to null (unless already changed)
            if ($optionValue->getOptiona() === $this) {
                $optionValue->setOptiona(null);
            }
        }

        return $this;
    }
}
