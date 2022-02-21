<?php

namespace App\Entity;

use App\Repository\BookRentalRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRentalRepository::class)
 */
class BookRental
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dueDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $returnDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="bookRentals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $book;

    /**
     * @ORM\ManyToOne(targetEntity=Sample::class, inversedBy="bookRentals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sample;

    /**
     * @ORM\ManyToOne(targetEntity=Rental::class, inversedBy="bookRentals")
     */
    private $rental;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDueDate(): ?\DateTimeInterface
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTimeInterface $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function getReturnDate(): ?\DateTimeInterface
    {
        return $this->returnDate;
    }

    public function setReturnDate(?\DateTimeInterface $returnDate): self
    {
        $this->returnDate = $returnDate;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    public function getSample(): ?Sample
    {
        return $this->sample;
    }

    public function setSample(?Sample $sample): self
    {
        $this->sample = $sample;

        return $this;
    }

    public function getRental(): ?Rental
    {
        return $this->rental;
    }

    public function setRental(?Rental $rental): self
    {
        $this->rental = $rental;

        return $this;
    }
}
