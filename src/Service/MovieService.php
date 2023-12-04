<?php
namespace App\Service;

use App\Entity\Movie;
use App\Models\Search\MovieSearch;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class MovieService extends BaseService
{
    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        parent::__construct($entityManagerInterface, Movie::class);
    }

    public function getAll(MovieSearch $search){
        return $this->entityRepository->getAll($search)->getResult();
    }

    public function create($movie, $genres)
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

        foreach($genres as $genre){
            $new->addGenre($genre);
        }

        return parent::add($new);

    }
}
