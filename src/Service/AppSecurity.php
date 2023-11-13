<?php
namespace App\Service;

use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class AppSecurity
 */
final class AppSecurity
{

    /**
     * AppSecurity constructor.
     *
     * @param Security $security
     */
    public function __construct(private Security $security)
    {
    }

    /**
     * @return UserInterface|void|null
     */
    public function getConnectedUser()
    {
        if (null !== $this->security->getUser()) {
            return $this->security->getUser();
        }

        return null;
    }
}
