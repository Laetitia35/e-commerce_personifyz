<?php

#[ORM\Entity]
class Personnalisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Color::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Color $color = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $text = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $font = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null; // Image uploadée par l'utilisateur

    #[ORM\Column(type: 'boolean')]
    private bool $isValidated = false;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $additionalOptions = [];

    public function getId(): ?int { return $this->id; }
    public function getProduct(): ?Product { return $this->product; }
    public function setProduct(Product $product): static { $this->product = $product; return $this; }

    public function getUser(): ?User { return $this->user; }
    public function setUser(User $user): static { $this->user = $user; return $this; }

    public function getColor(): ?Color { return $this->color; }
    public function setColor(?Color $color): static { $this->color = $color; return $this; }

    public function getText(): ?string { return $this->text; }
    public function setText(?string $text): static { $this->text = $text; return $this; }

    public function getFont(): ?string { return $this->font; }
    public function setFont(?string $font): static { $this->font = $font; return $this; }

    public function getImage(): ?string { return $this->image; }
    public function setImage(?string $image): static { $this->image = $image; return $this; }

    public function isValidated(): bool { return $this->isValidated; }
    public function setValidated(bool $isValidated): static { $this->isValidated = $isValidated; return $this; }

    public function getAdditionalOptions(): ?array { return $this->additionalOptions; }
    public function setAdditionalOptions(?array $additionalOptions): static { $this->additionalOptions = $additionalOptions; return $this; }
}

