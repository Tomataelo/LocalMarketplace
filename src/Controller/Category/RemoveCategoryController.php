<?php

namespace App\Controller\Category;

use App\Service\Category\RemoveCategoryService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/category/{categoryId}', name: 'removeCategory', methods: ['DELETE'])]
class RemoveCategoryController extends AbstractController
{
    public function __invoke(
        int $categoryId,
        LoggerInterface $logger,
        RemoveCategoryService $removeCategoryService
    ): JsonResponse
    {
        try {

            $removeCategoryService($categoryId);

        } catch (NotFoundHttpException $e) {
            $logger->warning($e->getMessage());
            return new JsonResponse([$e->getMessage()], 404);
        }

        return new JsonResponse(['success' => true]);
    }
}
