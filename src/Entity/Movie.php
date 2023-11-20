<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovieRepository::class)]
class Movie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idMovieDB = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $originalTitle = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $releaseDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $runtime = null;

    #[ORM\Column(nullable: true)]
    private ?int $budget = null;

    #[ORM\Column(nullable: true)]
    private ?int $revenue = null;

    #[ORM\Column(length: 55, nullable: true)]
    private ?string $originalLanguage = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $overview = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $posterPath = null;

    #[ORM\OneToMany(mappedBy: 'movie', targetEntity: UserMovie::class)]
    private Collection $userMovies;

    public function __construct()
    {
        $this->userMovies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdMovieDB(): ?int
    {
        return $this->idMovieDB;
    }

    public function setIdMovieDB(int $idMovieDB): static
    {
        $this->idMovieDB = $idMovieDB;

        return $this;
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

    public function getOriginalTitle(): ?string
    {
        return $this->originalTitle;
    }

    public function setOriginalTitle(?string $originalTitle): static
    {
        $this->originalTitle = $originalTitle;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): static
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getRuntime(): ?int
    {
        return $this->runtime;
    }

    public function setRuntime(?int $runtime): static
    {
        $this->runtime = $runtime;

        return $this;
    }

    public function getBudget(): ?int
    {
        return $this->budget;
    }

    public function setBudget(?int $budget): static
    {
        $this->budget = $budget;

        return $this;
    }

    public function getRevenue(): ?int
    {
        return $this->revenue;
    }

    public function setRevenue(?int $revenue): static
    {
        $this->revenue = $revenue;

        return $this;
    }

    public function getOriginalLanguage(): ?string
    {
        return $this->originalLanguage;
    }

    public function setOriginalLanguage(?string $originalLanguage): static
    {
        $this->originalLanguage = $originalLanguage;

        return $this;
    }

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function setOverview(?string $overview): static
    {
        $this->overview = $overview;

        return $this;
    }

    public function getPosterPath(): ?string
    {
        return $this->posterPath;
    }

    public function setPosterPath(?string $posterPath): static
    {
        $this->posterPath = $posterPath;

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
            $userMovie->setMovie($this);
        }

        return $this;
    }

    public function removeUserMovie(UserMovie $userMovie): static
    {
        if ($this->userMovies->removeElement($userMovie)) {
            // set the owning side to null (unless already changed)
            if ($userMovie->getMovie() === $this) {
                $userMovie->setMovie(null);
            }
        }

        return $this;
    }
}
