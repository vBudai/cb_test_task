<?php

namespace App\Controller;

use App\Controller\ResponseCreator\JsonResponseCreator;
use App\Entity\Factory\ProjectFactory;
use App\Exception\EntityValidationException;
use App\Model\ProjectModel;
use App\Validator\Request\EntityValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProjectController extends AbstractController
{
    public function __construct(private ProjectModel $model, private EntityValidator $validator){}

    #[Route('/project', name: 'project_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        try{
            $project = ProjectFactory::fromRequest($request);

            if($errors = $this->validator->validate($project)){
                throw new EntityValidationException($errors);
            }

            $this->model->createProjectInDb($project);

            return JsonResponseCreator::create(Response::HTTP_CREATED, 'Project created');
        }
        catch (EntityValidationException $e){
            return JsonResponseCreator::create(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
        catch (\Exception $e){
            return JsonResponseCreator::create(Response::HTTP_CONFLICT, $e->getMessage());
        }
    }

    #[Route('/projects', name: 'project_get_all', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        return JsonResponseCreator::create(Response::HTTP_OK, $this->model->getAllProjects());
    }

    #[Route('/project/{id}', name: 'project_delete', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        try{
            $this->model->deleteProjectById($id);

            return JsonResponseCreator::create(Response::HTTP_OK, 'Project deleted');
        }
        catch (\Exception $e) {
            return JsonResponseCreator::create(Response::HTTP_NOT_FOUND, $e->getMessage());
        }
    }

    #[Route('/project/close/{id}', name: 'project_update', requirements: ['id' => '\d+'], methods: ['PUT'])]
    public function update(int $id): JsonResponse
    {
        try{
            $this->model->closeProjectById($id);

            return JsonResponseCreator::create(Response::HTTP_OK, 'Project has been updated');
        } catch (\Exception $e) {
            return JsonResponseCreator::create(Response::HTTP_NOT_FOUND, $e->getMessage());
        }
    }
}
