<?php
namespace App\Service\Traits;

use App\Service\UserService;

trait AppServiceTrait
{
    /** @var UserService */
    private UserService $userService;

    public function getUserService(): UserService
    {
        return $this->userService;
    }

    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setUserService(UserService $userService) : void
    {
        $this->userService = $userService;
    }
}
