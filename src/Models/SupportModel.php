<?php

namespace App\Models;

class SupportModel
{
    private string $name;

    private int $idMovie;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getIdMovie(): int
    {
        return $this->idMovie;
    }

    public function setIdMovie(int $idMovie): void
    {
        $this->idMovie = $idMovie;
    }

}
