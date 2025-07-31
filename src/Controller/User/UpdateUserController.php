<?php

namespace App\Controller\User;

use App\Controller\BaseApiController;
use App\Dto\User\UpdateUserDto;
use App\Exception\ValidationException;
use App\Service\User\UpdateUserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[Route('/api/user/{userId}', name: 'updateUser', methods: ['PUT'])]
class UpdateUserController extends BaseApiController
{
    public function __invoke(
        int $userId,
        Request $request,
        UpdateUserService $updateUserService
    ): JsonResponse
    {
        try {

            $userDto = $this->serializer->deserialize($request->getContent(), UpdateUserDto::class, 'json');

            $updateUserService->updateUser($userId, $userDto);

        } catch (NotFoundHttpException $e) {
            $this->logger->error($e->getMessage());
            return new JsonResponse(["error" => 'User with id: ' . $userId . ' not found'], 404);

        } catch (ValidationException $e) {
            $this->logger->error($e->getMessage());
            return new JsonResponse(json_decode($e->getMessage(), true), 409);

        } catch (ExceptionInterface $e) {
            $this->logger->error('Deserialization error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Invalid input. Please ensure all required fields are entered correctly.'], 400);
        }

        return new JsonResponse(["success" => true]);
    }
}
