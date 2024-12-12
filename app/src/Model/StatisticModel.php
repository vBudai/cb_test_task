<?php

namespace App\Model;

use App\Model\SqlRequestFactory\DevelopersStatisticSqlFactory;
use App\Model\SqlRequestFactory\ProjectsStatisticSqlFactory;
use App\Model\SqlRequestFactory\StatisticSqlRequestFactory;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Connection;

class StatisticModel
{

    private Connection $connection;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->connection  = $entityManager->getConnection();
    }

    /**
     * @throws Exception
     */
    public function getProjectsCount(): int
    {
        return $this->connection
                            ->executeQuery(ProjectsStatisticSqlFactory::projectsCount())
                            ->fetchOne();
    }

    /**
     * @throws Exception
     */
    public function getCustomerProjectsCount(string $customer): int
    {
        return $this->connection
                            ->executeQuery(ProjectsStatisticSqlFactory::customerProjectsCount($customer))
                            ->fetchOne();
    }

    /**
     * @throws Exception
     */
    public function getDevelopersAverageAge(): int
    {
        return $this->connection
                            ->executeQuery(DevelopersStatisticSqlFactory::developersAverageAge())
                            ->fetchOne();
    }

    /**
     * @throws Exception
     */
    public function getDevelopersCount(): int
    {
        return $this->connection
                            ->executeQuery(DevelopersStatisticSqlFactory::developersCount())
                            ->fetchOne();
    }

}