<?php

namespace App\Model\RepositoryHelper;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProjectRepositoryHelper
{
    private ProjectRepository $repository;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repository = $entityManager->getRepository(Project::class);
    }

    public function isProjectExistsByEntity(Project $project): bool
    {
        return $this->repository->findOneBy([
                'name'     => $project->getName(),
                'customer' => $project->getCustomer(),
            ]) !== null;
    }

    public function getProjectById(int $id): ?Project
    {
        return $this->repository->findOneBy(['id' => $id]);
    }

    public function getAllProjects(): array
    {
        return $this->repository->findAll();
    }
}