<?php

namespace App\Entity;

use App\Repository\RentalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RentalRepository::class)
 */
class Rental
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Borrower::class, inversedBy="rentals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $borrower;

    /**
     * @ORM\ManyToMany(targetEntity=Book::class, inversedBy="rentals")
     */
    private $book;

    /**
     * @ORM\Column(type="date")
     */
    private $locationDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $returnStatus;

    /**
     * @ORM\Column(type="integer")
     */
    private $term;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observation;

    /**
     * @ORM\OneToMany(targetEntity=BookRental::class, mappedBy="rental")
     */
    private $bookRentals;

    public function __construct()
    {
        $this->book = new ArrayCollection();
        $this->bookRentals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBorrower(): ?Borrower
    {
        return $this->borrower;
    }

    public function setBorrower(?Borrower $borrower): self
    {
        $this->borrower = $borrower;

        return $this;
    }

    /**
     * @return Collection|Book[]
     */
    public function getBook(): Collection
    {
        return $this->book;
    }

    public function addBook(Book $book): self
    {
        if (!$this->book->contains($book)) {
            $this->book[] = $book;
        }

        return $this;
    }

    public function removeBook(Book $book): self
    {
        $this->book->removeElement($book);

        return $this;
    }

    public function getLocationDate(): ?\DateTimeInterface
    {
        return $this->locationDate;
    }

    public function setLocationDate(\DateTimeInterface $locationDate): self
    {
        $this->locationDate = $locationDate;

        return $this;
    }

    public function getReturnStatus(): ?bool
    {
        return $this->returnStatus;
    }

    public function setReturnStatus(bool $returnStatus): self
    {
        $this->returnStatus = $returnStatus;

        return $this;
    }

    public function getTerm(): ?int
    {
        return $this->term;
    }

    public function setTerm(int $term): self
    {
        $this->term = $term;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): self
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * @return Collection|BookRental[]
     */
    public function getBookRentals(): Collection
    {
        return $this->bookRentals;
    }

    public function addBookRental(BookRental $bookRental): self
    {
        if (!$this->bookRentals->contains($bookRental)) {
            $this->bookRentals[] = $bookRental;
            $bookRental->setRental($this);
        }

        return $this;
    }

    public function removeBookRental(BookRental $bookRental): self
    {
        if ($this->bookRentals->removeElement($bookRental)) {
            // set the owning side to null (unless already changed)
            if ($bookRental->getRental() === $this) {
                $bookRental->setRental(null);
            }
        }

        return $this;
    }
}
