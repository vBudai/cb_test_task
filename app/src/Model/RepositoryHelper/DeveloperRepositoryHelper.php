<?php

namespace App\Model\RepositoryHelper;

use App\Entity\Developer;
use App\Repository\DeveloperRepository;
use Doctrine\ORM\EntityManagerInterface;

class DeveloperRepositoryHelper
{

    private DeveloperRepository $repository;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Developer::class);
    }

    public function getAllDevelopers(): array
    {
        return $this->repository->findAll();
    }

    public function isDeveloperExistByEntity(Developer $developer): bool
    {
        return $this->repository->findOneBy([
                'fullName' => $developer->getFullName(),
                'email'    => $developer->getEmail(),
                'phone'    => $developer->getPhone(),
                'post'     => $developer->getPost(),
                'project'  => $developer->getProject(),
            ]) !== null;
    }

    public function getDeveloperById(int $id): ?Developer
    {
        return $this->repository->findOneBy(['id' => $id]);
    }

}