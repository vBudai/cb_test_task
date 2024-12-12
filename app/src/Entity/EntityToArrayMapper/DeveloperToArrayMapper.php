<?php

namespace App\Entity\EntityToArrayMapper;

use App\Entity\Developer;

class DeveloperToArrayMapper
{
    public static function map(Developer $developer): array
    {
        $result = [
            'id'        => $developer->getId(),
            'fullName'  => $developer->getFullName(),
            'post'      => $developer->getPost(),
            'email'     => $developer->getEmail(),
            'phone'     => $developer->getPhone(),
        ];

        if($project = $developer->getProject()){
            $result['project'] = ProjectToArrayMapper::map($project, false);
        }

        return $result;
    }
}