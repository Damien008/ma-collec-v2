<?php
namespace App\Service;

use App\Entity\Movie;
use App\Entity\Support;
use App\Entity\User;
use App\Entity\UserMovie;
use Doctrine\ORM\EntityManagerInterface;

class UserMovieService extends BaseService
{
    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        parent::__construct($entityManagerInterface, UserMovie::class);
    }

    /**
     * @param User $user
     * @param Movie $movie
     * @return string
     */
    public function create(User $user, Movie $movie, Support $support): string
    {
        $userMovie = $this->findOneBy(['user' => $user, 'movie' => $movie]);
        if($userMovie){
            return 'Ce film est déjà dans votre collection';
        }else{
            $userMovie = new UserMovie();
            $userMovie->setUser($user)
                ->setMovie($movie)
                ->setSupport($support)
                ->setAddDate(new \DateTime('now'));
            $this->add($userMovie);
            return 'Le film à été ajouté à votre collection';
        }
    }
}
