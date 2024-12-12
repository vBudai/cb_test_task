<?php

namespace App\Model;

use App\Entity\EntityToArrayMapper\ProjectToArrayMapper;
use App\Entity\Project;
use App\Model\RepositoryHelper\DeveloperRepositoryHelper;
use App\Model\RepositoryHelper\ProjectRepositoryHelper;
use App\Repository\DeveloperRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProjectModel
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

    /**
     * @throws \Exception
     */
    public function createProjectInDb(Project $project): void
    {
        if($this->projectRepositoryHelper->isProjectExistsByEntity($project)){
            throw new \Exception("Project already exists");
        }
        $this->entityManager->persist($project);
        $this->entityManager->flush();
    }

    public function getAllProjects(): array
    {
        $projectsEntities = $this->projectRepositoryHelper->getAllProjects();
        $projectsArr = [];
        foreach ($projectsEntities as $projectsEntity) {
            $projectsArr[] = ProjectToArrayMapper::map($projectsEntity);
        }
        return $projectsArr;
    }

    public function deleteProjectById(int $id): void
    {
        $project = $this->projectRepositoryHelper->getProjectById($id);
        $this->entityManager->remove($project);
        $this->entityManager->flush();
    }

    /**
     * @throws \Exception
     */
    public function closeProjectById(int $id): void
    {
        if(!$project = $this->projectRepositoryHelper->getProjectById($id)){
            throw new \Exception("Project does not exists");
        }
        $project->setClose(true);
        $this->entityManager->persist($project);
        $this->entityManager->flush();
    }

}