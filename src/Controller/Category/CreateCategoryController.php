<?php

namespace App\Controller\Category;

use App\Dto\Category\CategoryDto;

use App\Service\Category\CreateCategoryService;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/category', name: 'createCategory', methods: ['POST'])]
final class CreateCategoryController
{
    public function __invoke(
        Request $request,
        SerializerInterface $serializer,
        LoggerInterface $logger,
        CreateCategoryService $createCategoryService,
    ): JsonResponse
    {
        try {

            $deserialized = $serializer->deserialize($request->getContent(), CategoryDto::class, 'json');

            $createCategoryService($deserialized);

        } catch (ExceptionInterface $e) {
            $logger->error('Deserialization error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Invalid input. Please ensure all required fields are entered correctly.'], 400);
        }


        return new JsonResponse([]);
    }
}
