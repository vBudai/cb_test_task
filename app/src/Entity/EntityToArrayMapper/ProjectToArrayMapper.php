<?php

namespace App\Entity\EntityToArrayMapper;

use App\Entity\Project;

class ProjectToArrayMapper
{
    public static function map(Project $project = null, bool $withDevelopers = true): array
    {
        $result = [
            'id'         => $project->getId(),
            'name'       => $project->getName(),
            'customer'   => $project->getCustomer(),
        ];

        $developersArr = [];
        if($withDevelopers){
            $developersEntities = $project->getDevelopers();
            foreach ($developersEntities as $developerEntity) {
                $developer = DeveloperToArrayMapper::map($developerEntity);
                unset($developer['project']);

                $developersArr[] = $developer;
            }
            $result['developers'] = $developersArr;
        }

        return $result;
    }
}