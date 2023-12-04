<?php

namespace App\Command;

use App\Entity\Genre;
use App\Service\CallApiService;
use App\Service\GenreService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddMovieGenre extends Command
{
    protected static $defaultName = "app:add-movie-genre";

    public function __construct(private readonly CallApiService $callApiService, private readonly GenreService $genreService)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $genres = $this->callApiService->getMovieGenre();

        foreach ($genres['genres'] as $genre){
            $newGenre = new Genre();
            $newGenre->setName($genre['name'])
                ->setIdMovieDb($genre['id']);
            $this->genreService->add($newGenre);
        }
        $output->write('création des genres OK');
        return Command::SUCCESS;
    }
}
