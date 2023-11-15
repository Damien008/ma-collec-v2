<?php
namespace App\Service\Traits;

use App\Service\CallApiService;
use App\Service\UserService;

trait AppServiceTrait
{
    /** @var UserService */
    private UserService $userService;

    private CallApiService $callApiService;

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
}
