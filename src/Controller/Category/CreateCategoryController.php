<?php

namespace App\Controller\Category;

use App\Dto\Category\CategoryDto;
use App\Exception\ValidationException;
use App\Service\Category\CreateCategoryService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/category', name: 'createCategory', methods: ['POST'])]
final class CreateCategoryController extends AbstractController
{
    public function __invoke(
        Request                      $request,
        SerializerInterface          $serializer,
        LoggerInterface              $logger,
        CreateCategoryService       $createCategoryService,
    ): JsonResponse
    {
        try {

            $categoryDto = $serializer->deserialize($request->getContent(), CategoryDto::class, 'json');

            $createCategoryService($categoryDto);

            $serializedCategory = $serializer->serialize($categoryDto, 'json');

        } catch (ExceptionInterface $e) {
            $logger->error('Deserialization error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Invalid input. Please ensure all required fields are entered correctly.'], 400);

        } catch (ValidationException $e) {
            $logger->error('Validation error: ' . $e->getMessage());
            return new JsonResponse(["errors" => json_decode($e->getMessage() , true)], 422);

        } catch (\InvalidArgumentException $e) {
            $logger->error('InvalidArgumentException: ' . $e->getMessage());
            return new JsonResponse(['error' => $e->getMessage()], 400);
        }


        return new JsonResponse($serializedCategory, 201, [], true);
    }
}
