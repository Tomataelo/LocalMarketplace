<?php

namespace App\Controller\Category;

use App\Controller\BaseApiController;
use App\Dto\Category\UpdateCategoryDto;
use App\Service\Category\UpdateCategoryService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[Route('/api/category/{categoryId}', name: 'updateCategory', methods: ['PUT'])]
class UpdateCategoryController extends BaseApiController
{
    public function __invoke(
        int $categoryId,
        Request $request,
        UpdateCategoryService $updateCategoryService
    ): JsonResponse
    {
        try {

            $UpdateCategoryDto = $this->serializer->deserialize($request->getContent(), UpdateCategoryDto::class, 'json');

            $updateCategoryService($categoryId, $UpdateCategoryDto);

        } catch (ExceptionInterface $e) {
            $this->logger->error('Deserialization error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Invalid input. Please ensure all required fields are entered correctly.'], 400);

        } catch (NotFoundHttpException $e){
            $this->logger->error($e->getMessage());
            return new JsonResponse([$e->getMessage()], 404);

        }

        return new JsonResponse(["success" => true]);
    }
}
