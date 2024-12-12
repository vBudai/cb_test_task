<?php

namespace App\Controller;

use App\Controller\ResponseCreator\JsonResponseCreator;
use App\Entity\Factory\DeveloperFactory;
use App\Exception\EntityValidationException;
use App\Exception\ProjectNotFoundException;
use App\Model\DeveloperModel;
use App\Validator\Request\EntityValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DevelopersController extends AbstractController
{

    public function __construct(private DeveloperModel $model, private EntityValidator $validator, private DeveloperFactory $developerFactory){}

    #[Route('/developer', name: 'create_developer', methods: ['POST'],format: 'json')]
    public function create(Request $request): JsonResponse
    {
        try{
            $developer = $this->developerFactory->fromRequest($request);

            if ($errors = $this->validator->validate($developer)) {
                throw new EntityValidationException($errors);
            }

            $this->model->createDeveloperInDb($developer);

            return JsonResponseCreator::create(Response::HTTP_CREATED, 'Developer created');
        }
        catch (ProjectNotFoundException | EntityValidationException $e){
            return JsonResponseCreator::create(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
        catch (\Exception $e){
            return JsonResponseCreator::create(Response::HTTP_CONFLICT, $e->getMessage());
        }
    }

    #[Route('/developer/{id}', name: 'delete_developer', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        try{
            $this->model->deleteDeveloperById($id);

            return JsonResponseCreator::create(Response::HTTP_OK, 'Developer deleted');
        }
        catch (\Exception $e) {
            return JsonResponseCreator::create(Response::HTTP_NOT_FOUND, $e->getMessage());
        }
    }

    #[Route('/developer/{developerId}/transfer/{projectId}', name: 'transfer_developer', requirements: ['developerId' => '\d+', 'projectId' => '\d+'], methods: ['PUT'])]
    public function transferToProject(int $developerId, int $projectId):JsonResponse
    {
        try{
            $this->model->transferDeveloperToProject($developerId, $projectId);

            return JsonResponseCreator::create(Response::HTTP_OK, 'Developer has been transferred');
        }
        catch (\Exception $e) {
            return JsonResponseCreator::create(Response::HTTP_NOT_FOUND, $e->getMessage());
        }
    }

    #[Route('/developers', name: 'get_all_developers', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        return JsonResponseCreator::create(Response::HTTP_OK, $this->model->getAllDevelopers());
    }
}