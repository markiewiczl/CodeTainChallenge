<?php

namespace App\Entity;

use App\Repository\AnnouncementsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnnouncementsRepository::class)
 */
class Announcements
{
    private int $id;

    private string $title;

    private string $description;

    private Categories $category;

    private int $priceNet;

    private int $priceGross;

    private ?string $image;

    private \DateTimeInterface $createdAt;

    private Users $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory(?Categories $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPriceNet(): ?int
    {
        return $this->priceNet;
    }

    public function setPriceNet(int $priceNet): self
    {
        $this->priceNet = $priceNet;

        return $this;
    }

    public function getPriceGross(): ?int
    {
        return $this->priceGross;
    }

    public function setPriceGross(int $priceGross): self
    {
        $this->priceGross = $priceGross;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }
}
