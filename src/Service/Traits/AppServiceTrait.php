<?php
namespace App\Service\Traits;

use App\Service\CallApiService;
use App\Service\GenreService;
use App\Service\MovieService;
use App\Service\SupportService;
use App\Service\UserMovieService;
use App\Service\UserService;

trait AppServiceTrait
{
    /** @var UserService */
    private UserService $userService;

    private CallApiService $callApiService;

    private MovieService $movieService;

    private UserMovieService $userMovieService;

    private SupportService $supportService;

    private GenreService $genreService;

    public function getUserService(): UserService
    {
        return $this->userService;
    }

    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setUserService(UserService $userService) : void
    {
        $this->userService = $userService;
    }

    public function getCallApiService(): CallApiService
    {
        return $this->callApiService;
    }

    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setCallApiService(CallApiService $callApiService) : void
    {
        $this->callApiService = $callApiService;
    }

    public function getMovieService(): MovieService
    {
        return $this->movieService;
    }

    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setMovieService(MovieService $movieService): void
    {
        $this->movieService = $movieService;
    }

    public function getUserMovieService(): UserMovieService
    {
        return $this->userMovieService;
    }

    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setUserMovieService(UserMovieService $userMovieService): void
    {
        $this->userMovieService = $userMovieService;
    }

    public function getSupportService(): SupportService
    {
        return $this->supportService;
    }

    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setSupportService(SupportService $supportService): void
    {
        $this->supportService = $supportService;
    }

    public function getGenreService(): GenreService
    {
        return $this->genreService;
    }

    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setGenreService(GenreService $genreService): void
    {
        $this->genreService = $genreService;
    }


}
