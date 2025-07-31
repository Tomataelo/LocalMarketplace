<?php

namespace App\Controller\Category;

use App\Dto\Category\UpdateCategoryDto;
use App\Exception\ValidationException;
use App\Service\Category\UpdateCategoryService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/category/{categoryId}', name: 'updateCategory', methods: ['PUT'])]
class UpdateCategoryController extends AbstractController
{
    public function __invoke(
        int $categoryId,
        Request $request,
        LoggerInterface $logger,
        SerializerInterface $serializer,
        UpdateCategoryService $updateCategoryService
    ): JsonResponse
    {
        try {

            $UpdateCategoryDto = $serializer->deserialize($request->getContent(), UpdateCategoryDto::class, 'json');

            $updateCategoryService($categoryId, $UpdateCategoryDto);

        } catch (ExceptionInterface $e) {
            $logger->error('Deserialization error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Invalid input. Please ensure all required fields are entered correctly.'], 400);

        } catch (NotFoundHttpException $e){
            $logger->error($e->getMessage());
            return new JsonResponse([$e->getMessage()], 404);

        }

        return new JsonResponse(["success" => true]);
    }
}
