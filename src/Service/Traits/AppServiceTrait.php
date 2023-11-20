<?php
namespace App\Service\Traits;

use App\Service\CallApiService;
use App\Service\MovieService;
use App\Service\UserMovieService;
use App\Service\UserService;

trait AppServiceTrait
{
    /** @var UserService */
    private UserService $userService;

    private CallApiService $callApiService;

    private MovieService $movieService;

    private UserMovieService $userMovieService;

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
}
