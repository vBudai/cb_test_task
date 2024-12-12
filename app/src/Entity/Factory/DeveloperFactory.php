<?php

namespace App\Entity\Factory;

use App\Entity\Developer;
use App\Entity\Project;
use App\Exception\ProjectNotFoundException;
use App\Model\RepositoryHelper\ProjectRepositoryHelper;
use Symfony\Component\HttpFoundation\Request;

class DeveloperFactory
{
    public function __construct(private ProjectRepositoryHelper $projectRepositoryHelper){}

    /**
     * @throws ProjectNotFoundException
     */
    public function fromRequest(Request $request): Developer
    {
        $data = $request->toArray();
        $developer = new Developer();

        $developer
            ->setFullName($data['fullName'] ?? '')
            ->setPhone($data['phone'] ?? '')
            ->setEmail($data['email'] ?? '')
            ->setPost($data['post'] ?? '')
            ->setAge($data['age'] ?? null)
            ->setProject($this->getProjectById($data['project'] ?? 0));

        return $developer;
    }

    /**
     * @throws ProjectNotFoundException
     */
    private function getProjectById(int $id): ?Project
    {
        $project = null;
        if($id && !$project = $this->projectRepositoryHelper->getProjectById($id)){
            throw new ProjectNotFoundException($id);
        }
        return $project;
    }
}