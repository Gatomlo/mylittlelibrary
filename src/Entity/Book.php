<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookRepository::class)
 */
class Book
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $ISBN;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $owner;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $shelf;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $abstract;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $paging;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $editor;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $language;

    /**
     * @ORM\ManyToMany(targetEntity=Rental::class, mappedBy="book")
     */
    private $rentals;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $year;

    /**
     * @ORM\OneToMany(targetEntity=BookRental::class, mappedBy="book")
     */
    private $bookRentals;

    public function __construct()
    {
        $this->rentals = new ArrayCollection();
        $this->bookRentals = new ArrayCollection();
        function genererChaineAleatoire($longueur = 5)
        {
           $caracteres = '0123456789';
           $longueurMax = strlen($caracteres);
           $chaineAleatoire = '';
           for ($i = 0; $i < $longueur; $i++)
           {
             $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];
           }
           return $chaineAleatoire;
        }
        $this->setCode(genererChaineAleatoire());
    }

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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getISBN(): ?string
    {
        return $this->ISBN;
    }

    public function setISBN(string $ISBN): self
    {
        $this->ISBN = $ISBN;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
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

    public function getOwner(): ?string
    {
        return $this->owner;
    }

    public function setOwner(string $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getShelf(): ?string
    {
        return $this->shelf;
    }

    public function setShelf(?string $shelf): self
    {
        $this->shelf = $shelf;

        return $this;
    }

    public function getAbstract(): ?string
    {
        return $this->abstract;
    }

    public function setAbstract(?string $abstract): self
    {
        $this->abstract = $abstract;

        return $this;
    }

    public function getPaging(): ?int
    {
        return $this->paging;
    }

    public function setPaging(?int $paging): self
    {
        $this->paging = $paging;

        return $this;
    }

    public function getEditor(): ?string
    {
        return $this->editor;
    }

    public function setEditor(?string $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return Collection|Rental[]
     */
    public function getRentals(): Collection
    {
        return $this->rentals;
    }

    public function addRental(Rental $rental): self
    {
        if (!$this->rentals->contains($rental)) {
            $this->rentals[] = $rental;
            $rental->addBook($this);
        }

        return $this;
    }

    public function removeRental(Rental $rental): self
    {
        if ($this->rentals->removeElement($rental)) {
            $rental->removeBook($this);
        }

        return $this;
    }

    public function getYear(): ?string
    {
        return $this->year;
    }

    public function setYear(?string $year): self
    {
        $this->year = $year;

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
            $bookRental->setBook($this);
        }

        return $this;
    }

    public function removeBookRental(BookRental $bookRental): self
    {
        if ($this->bookRentals->removeElement($bookRental)) {
            // set the owning side to null (unless already changed)
            if ($bookRental->getBook() === $this) {
                $bookRental->setBook(null);
            }
        }

        return $this;
    }
}
