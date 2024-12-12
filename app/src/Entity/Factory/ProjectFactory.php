<?php

namespace App\Entity\Factory;

use App\Entity\Project;
use Symfony\Component\HttpFoundation\Request;

class ProjectFactory
{
    public static function fromRequest(Request $request): Project
    {
        $data = $request->toArray();
        $project = new Project();
        $project
            ->setName($data['name'] ?? '')
            ->setCustomer($data['customer'] ?? '')
            ->setClose($data['is_close'] ?? false);
        return $project;
    }
}