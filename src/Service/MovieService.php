<?php
namespace App\Service;

use App\Entity\Movie;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class MovieService extends BaseService
{
    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        parent::__construct($entityManagerInterface, Movie::class);
    }


    public function create($movie)
    {
        $new = new Movie();
        $new->setIdMovieDB($movie['id'])
            ->setTitle($movie['title'])
            ->setOriginalTitle($movie['original_title'])
            ->setReleaseDate(new DateTime($movie['release_date']))
            ->setRuntime($movie['runtime'])
            ->setBudget($movie['budget'])
            ->setRevenue($movie['revenue'])
            ->setOriginalLanguage($movie['original_language'])
            ->setOverview($movie['overview'])
            ->setPosterPath($movie['poster_path']);

        return parent::add($new);

    }
}
