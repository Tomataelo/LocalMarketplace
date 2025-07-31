<?php

namespace App\Controller\Category;

use App\Controller\BaseApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use App\Service\Category\GetCategoryService;

class GetCategoryController extends BaseApiController
{
    #[Route('/api/category/{categoryId}', name: 'getOneCategory', methods: ['GET'])]
    public function getOneCategory(int $categoryId, GetCategoryService $getCategoryService): JsonResponse
    {
        try {

            $categoryDto = $getCategoryService->getCategory($categoryId);

            $serializedCategory = $this->serializer->serialize($categoryDto, 'json');

        } catch (NotFoundHttpException $e) {
            $this->logger->error($e->getMessage());
            return new JsonResponse(["error" => $e->getMessage()], 404);

        } catch (ExceptionInterface $e) {
            $this->logger->error('Serialization error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Invalid serialization.'], 400);
        }

        return new JsonResponse($serializedCategory, 200, [], true);
    }


    #[Route('/api/categories', name: 'getAllCategories', methods: ['GET'])]
    public function getAllCategories(GetCategoryService $getCategoryService): JsonResponse
    {
        try {

            $categoriesDto = $getCategoryService->getAllCategories();

            $serializedCategories = $this->serializer->serialize($categoriesDto, 'json');

        } catch (NotFoundHttpException $e) {
            $this->logger->error($e->getMessage());
            return new JsonResponse(["error" => $e->getMessage()], 404);

        } catch (ExceptionInterface $e) {
            $this->logger->error('Serialization error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Invalid serialization.'], 400);
        }

        return new JsonResponse($serializedCategories, 200, [], true);
    }
}
