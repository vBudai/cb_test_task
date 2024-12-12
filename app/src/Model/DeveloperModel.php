<?php

namespace App\Model;

use App\Entity\Developer;
use App\Entity\EntityToArrayMapper\DeveloperToArrayMapper;
use App\Entity\Project;
use App\Model\RepositoryHelper\DeveloperRepositoryHelper;
use App\Model\RepositoryHelper\ProjectRepositoryHelper;
use App\Repository\DeveloperRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;


class DeveloperModel
{

    private EntityManagerInterface $entityManager;

    private DeveloperRepositoryHelper $developerRepositoryHelper;
    private ProjectRepositoryHelper   $projectRepositoryHelper;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->developerRepositoryHelper = new DeveloperRepositoryHelper($entityManager);
        $this->projectRepositoryHelper   = new ProjectRepositoryHelper($entityManager);
    }

    public function getAllDevelopers(): array
    {
        $developersEntities = $this->developerRepositoryHelper->getAllDevelopers();
        $developersArr = [];
        foreach ($developersEntities as $developerEntity) {
            $developersArr[] = DeveloperToArrayMapper::map($developerEntity);
        }
        return $developersArr;
    }

    /**
     * @throws \Exception
     */
    public function createDeveloperInDb(Developer $developer): void
    {
        if($this->developerRepositoryHelper->isDeveloperExistByEntity($developer)){
            throw new \Exception("Developer already exist");
        }
        $this->entityManager->persist($developer);
        $this->entityManager->flush();
    }

    /**
     * @throws \Exception
     */
    public function deleteDeveloperById(int $id): void
    {
        if(!$developer = $this->developerRepositoryHelper->getDeveloperById($id)){
            throw new \Exception("Developer does not exist");
        }
        $this->entityManager->remove($developer);
        $this->entityManager->flush();
    }

    /**
     * @throws \Exception
     */
    public function transferDeveloperToProject(int $developerId, int $projectId): void
    {
        if (!$developer = $this->developerRepositoryHelper->getDeveloperById($developerId)) {
            throw new \Exception("Developer does not exist");
        } else if (!$project = $this->projectRepositoryHelper->getProjectById($projectId)) {
            throw new \Exception("Project does not exist");
        }

        $developer->setProject($project);
        $this->entityManager->persist($developer);
        $this->entityManager->flush();
    }
}