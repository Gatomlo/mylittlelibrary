<?php

namespace App\Entity;

use App\Repository\SampleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SampleRepository::class)
 */
class Sample
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
    private $code;

    /**
     * @ORM\OneToMany(targetEntity=BookRental::class, mappedBy="sample",cascade={"remove"})
     */
    private $bookRentals;

    /**
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="samples",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $book;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getBook(): ?book
    {
        return $this->book;
    }

    public function setBook(?book $book): self
    {
        $this->book = $book;

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
            $bookRental->setSample($this);
        }

        return $this;
    }

    public function removeBookRental(BookRental $bookRental): self
    {
        if ($this->bookRentals->removeElement($bookRental)) {
            // set the owning side to null (unless already changed)
            if ($bookRental->getSample() === $this) {
                $bookRental->setSample(null);
            }
        }

        return $this;
    }
}
