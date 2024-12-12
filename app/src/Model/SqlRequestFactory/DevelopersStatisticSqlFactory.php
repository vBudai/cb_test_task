<?php

namespace App\Model\SqlRequestFactory;

class DevelopersStatisticSqlFactory
{

    private const TABLE_NAME = 'developer';

    public static function developersCount(): string
    {
        return "SELECT COUNT(id) count
                FROM " . self::TABLE_NAME . ";";
    }

    public static function developersAverageAge(): string
    {
        return "SELECT AVG(age) 
                FROM " . self::TABLE_NAME .";";
    }

}