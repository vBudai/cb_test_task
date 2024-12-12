<?php

namespace App\Model\SqlRequestFactory;

class ProjectsStatisticSqlFactory
{
    private const TABLE_NAME = 'project';

    public static function projectsCount(): string
    {
        return "SELECT COUNT(id) count
                FROM " . self::TABLE_NAME . ";";
    }

    public static function customerProjectsCount(string $customer): string
    {
        return "SELECT COUNT(id)  count
                FROM " . self::TABLE_NAME . "
                WHERE customer='$customer';";
    }
}