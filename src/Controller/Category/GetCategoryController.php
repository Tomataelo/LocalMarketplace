<?php

namespace App\Controller\Category;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use App\Service\Category\GetCategoryService;

class GetCategoryController extends AbstractController
{
    #[Route('/api/category/{categoryId}', name: 'getOneCategory', methods: ['GET'])]
    public function getOneCategory(
        int $categoryId,
        SerializerInterface $serializer,
        LoggerInterface $logger,
        GetCategoryService $getCategoryService
    ): JsonResponse
    {
        try {

            $categoryDto = $getCategoryService->getCategory($categoryId);

            $serializedCategory = $serializer->serialize($categoryDto, 'json');

        } catch (NotFoundHttpException $e) {
            $logger->error($e->getMessage());
            return new JsonResponse(["error" => $e->getMessage()], 404);

        } catch (ExceptionInterface $e) {
            $logger->error('Serialization error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Invalid serialization.'], 400);
        }

        return new JsonResponse($serializedCategory, 200, [], true);
    }


    #[Route('/api/categories', name: 'getAllCategories', methods: ['GET'])]
    public function getAllCategories(
        SerializerInterface $serializer,
        LoggerInterface $logger,
        GetCategoryService $getCategoryService
    ): JsonResponse
    {
        try {

            $categoriesDto = $getCategoryService->getAllCategories();

            $serializedCategories = $serializer->serialize($categoriesDto, 'json');

        } catch (NotFoundHttpException $e) {
            $logger->error($e->getMessage());
            return new JsonResponse(["error" => $e->getMessage()], 404);

        } catch (ExceptionInterface $e) {
            $logger->error('Serialization error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Invalid serialization.'], 400);
        }

        return new JsonResponse($serializedCategories, 200, [], true);
    }
}
