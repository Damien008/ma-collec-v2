<?php

namespace App\Service;

use App\Entity\Genre;
use Doctrine\ORM\EntityManagerInterface;

class GenreService extends BaseService
{
    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        parent::__construct($entityManagerInterface, Genre::class);
    }

}
