<?php

namespace App\Exception;

class ProjectNotFoundException extends \Exception
{
    public function __construct(int $projectId)
    {
        parent::__construct("Project with id {$projectId} not found");
    }
}