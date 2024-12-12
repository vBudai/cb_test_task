<?php

namespace App\Controller;

use App\Model\StatisticModel;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StatisticsController extends AbstractController
{

    public function __construct(private StatisticModel $model){}

    #[Route('/statistics/projects/count', name: 'statistics_projects_count', methods: ['GET'])]
    public function projectsCount(): JsonResponse
    {
        return $this->createResponseModelMethod([$this->model, 'getProjectsCount']);
    }

    #[Route('/statistics/projects/count/customer/{name}', name: 'statistics_customer_projects_count',  methods: ['GET'])]
    public function customerProjectsCount(string $name): JsonResponse
    {
        return $this->createResponseModelMethod([$this->model, 'getCustomerProjectsCount'], $name);
    }

    #[Route('/statistics/developers/average_age', name: 'statistics_developers_average_age', methods: ['GET'])]
    public function developersAverageAge(): JsonResponse
    {
        return $this->createResponseModelMethod([$this->model, 'getDevelopersAverageAge']);
    }

    #[Route('/statistics/developers/count', name: 'statistics_developers_count', methods: ['GET'])]
    public function developersCount(): JsonResponse
    {
       return $this->createResponseModelMethod([$this->model, 'getDevelopersCount']);
    }

    private function createResponseModelMethod(callable $modelMethod, mixed ...$modelMethodArguments): JsonResponse
    {
        try{
            return $this->json([
                'code'   => Response::HTTP_OK,
                'status' => 'success',
                'data'   => $modelMethod(...$modelMethodArguments),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->json([
                'code'   => Response::HTTP_INTERNAL_SERVER_ERROR,
                'status' => 'error',
                'data'   => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
