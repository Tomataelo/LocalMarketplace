<?php

namespace App\Controller\User;

use App\Dto\User\UpdateUserDto;
use App\Exception\ValidationException;
use App\Service\User\UpdateUserService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/user/{userId}', name: 'updateUser', methods: ['PUT'])]
class UpdateUserController extends AbstractController
{
    public function __invoke(
        int $userId,
        LoggerInterface $logger,
        Request $request,
        SerializerInterface $serializer,
        UpdateUserService $updateUserService
    ): JsonResponse
    {
        try {

            $userDto = $serializer->deserialize($request->getContent(), UpdateUserDto::class, 'json');

            $updateUserService->updateUser($userId, $userDto);

        } catch (NotFoundHttpException $e) {
            $logger->error($e->getMessage());
            return new JsonResponse(["error" => 'User with id: ' . $userId . ' not found'], 404);

        } catch (ValidationException $e) {
            $logger->error($e->getMessage());
            return new JsonResponse(json_decode($e->getMessage(), true), 409);

        } catch (ExceptionInterface $e) {
            $logger->error('Deserialization error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Invalid input. Please ensure all required fields are entered correctly.'], 400);
        }

        return new JsonResponse(["success" => true]);
    }
}
