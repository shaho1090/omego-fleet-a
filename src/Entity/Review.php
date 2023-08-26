<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use App\Repository\ReviewRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource(
    uriTemplate: '/cars/{CarId}/reviews',
    operations: [ new GetCollection() ],
    uriVariables: [
        'CarId' => new Link(toProperty: 'car', fromClass: Car::class),
    ]
)]
#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $star_rating = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $review_text = null;

    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $reviewer = null;


    #[ORM\ManyToOne(inversedBy: 'reviews')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Car $car = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStarRating(): ?int
    {
        return $this->star_rating;
    }

    public function setStarRating(int $star_rating): static
    {
        $this->star_rating = $star_rating;

        return $this;
    }

    public function getReviewText(): ?string
    {
        return $this->review_text;
    }

    public function setReviewText(?string $review_text): static
    {
        $this->review_text = $review_text;

        return $this;
    }

    public function getReviewer(): ?User
    {
        return $this->reviewer;
    }

    public function setReviewer(?User $reviewer): static
    {
        $this->reviewer = $reviewer;

        return $this;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): static
    {
        $this->car = $car;

        return $this;
    }
}
