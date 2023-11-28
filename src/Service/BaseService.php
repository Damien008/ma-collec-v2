<?php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\UnitOfWork;
use Doctrine\Persistence\ObjectRepository;

/**
 * Class BaseService
 */
abstract class BaseService
{
    /**
     * @var ObjectRepository
     */
    protected $entityRepository;

    /**
     * BaseService constructor.
     *
     * @param string|null            $entityClassName
     * @param EntityManagerInterface $entityManagerInterface
     */
    public function __construct(private readonly EntityManagerInterface $entityManagerInterface, string $entityClassName)
    {
        $this->entityRepository       = $entityManagerInterface->getRepository($entityClassName);
    }

    /**
     * @param array $param
     * @param array $sort
     *
     * @return array
     */
    public function findAll(array $param = [], array $sort = []): array
    {
        return $this->entityRepository->findBy($param, $sort);
    }

    /**
     * @param int $id
     *
     * @return object|null
     */
    public function findById(int $id): object|null
    {
        return $this->entityRepository->find($id);
    }

    /**
     * @param array $criteria
     *
     * @return object|null
     */
    public function findOneBy(array $criteria): object|null
    {
        return $this->entityRepository->findOneBy($criteria);
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     *
     * @return object[]
     */
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null): object
    {
        return $this->entityRepository->findBy($criteria, $orderBy, $limit, $offset);
    }

    /**
     * @param $entity
     * @param bool $flush
     *
     * @return mixed
     */
    public function add($entity, bool $flush = true): mixed
    {
        $this->entityManagerInterface->persist($entity);
        if ($flush) {
            $this->entityManagerInterface->flush();
        }

        return $entity;
    }

    /**
     * @param $entity
     * @param bool $flush
     * @return mixed
     */
    public function update($entity, bool $flush = true): mixed
    {
        $this->entityManagerInterface->persist($entity);
        if ($flush) {
            $this->entityManagerInterface->flush();
        }

        return $entity;
    }

    /**
     * @param $entity
     */
    public function delete($entity): void
    {
        $this->entityManagerInterface->remove($entity);
        $this->entityManagerInterface->flush();
    }

    public function flush(): void
    {
        $this->entityManagerInterface->flush();
    }

    public function clear(): void
    {
        $this->entityManagerInterface->clear();
    }

}


