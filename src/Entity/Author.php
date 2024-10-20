<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $username = null;

    #[ORM\Column(length: 50)]
    private ?string $email = null;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\OneToMany(targetEntity: Book::class,
    mappedBy: 'authorid',    
    cascade: ["persist","remove"])]
    private Collection $books;

    /**
     * @var Collection<int, Testt>
     */
    #[ORM\OneToMany(targetEntity: Testt::class, mappedBy: 'author')]
    private Collection $testts;

   

    public function __construct()
    {
        $this->books = new ArrayCollection();
        $this->testts = new ArrayCollection();
    }

   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->setAuthorid($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getAuthorid() === $this) {
                $book->setAuthorid(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Testt>
     */
    public function getTestts(): Collection
    {
        return $this->testts;
    }

    public function addTestt(Testt $testt): static
    {
        if (!$this->testts->contains($testt)) {
            $this->testts->add($testt);
            $testt->setAuthor($this);
        }

        return $this;
    }

    public function removeTestt(Testt $testt): static
    {
        if ($this->testts->removeElement($testt)) {
            // set the owning side to null (unless already changed)
            if ($testt->getAuthor() === $this) {
                $testt->setAuthor(null);
            }
        }

        return $this;
    }

    

}
