<?php
namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


class UserService extends BaseService
{
    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        parent::__construct($entityManagerInterface, User::class);
    }

    public function create(User $newUser)
    {
        $newUser->setCreatedAt(new \DateTimeImmutable('now'));
        return $this->add($newUser);
    }
}