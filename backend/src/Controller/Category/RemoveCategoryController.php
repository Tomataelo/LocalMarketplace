<?php

namespace App\Controller\Category;

use App\Controller\BaseApiController;
use App\Service\Category\RemoveCategoryService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/category/{categoryId}', name: 'removeCategory', methods: ['DELETE'])]
class RemoveCategoryController extends BaseApiController
{
    public function __invoke(int $categoryId, RemoveCategoryService $removeCategoryService): JsonResponse
    {
        try {

            $removeCategoryService($categoryId);

        } catch (NotFoundHttpException $e) {
            $this->logger->warning($e->getMessage());
            return new JsonResponse([$e->getMessage()], 404);
        }

        return new JsonResponse(['success' => true]);
    }
}
