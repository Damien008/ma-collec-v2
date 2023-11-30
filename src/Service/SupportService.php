<?php

namespace App\Service;

use App\Entity\Support;
use Doctrine\ORM\EntityManagerInterface;

class SupportService extends BaseService
{
    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        parent::__construct($entityManagerInterface, Support::class);
    }
}