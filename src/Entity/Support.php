<?php

namespace App\Entity;

use App\Repository\SupportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SupportRepository::class)]
class Support
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 55)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'support', targetEntity: UserMovie::class)]
    private Collection $userMovies;


    public function __construct()
    {
        $this->movies = new ArrayCollection();
        $this->userMovies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, UserMovie>
     */
    public function getUserMovies(): Collection
    {
        return $this->userMovies;
    }

    public function addUserMovie(UserMovie $userMovie): static
    {
        if (!$this->userMovies->contains($userMovie)) {
            $this->userMovies->add($userMovie);
            $userMovie->setSupport($this);
        }

        return $this;
    }

    public function removeUserMovie(UserMovie $userMovie): static
    {
        if ($this->userMovies->removeElement($userMovie)) {
            // set the owning side to null (unless already changed)
            if ($userMovie->getSupport() === $this) {
                $userMovie->setSupport(null);
            }
        }

        return $this;
    }

}
