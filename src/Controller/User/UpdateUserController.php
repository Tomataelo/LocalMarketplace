<?php

namespace App\Controller\User;

use App\Dto\User\UpdateUserDto;
use App\Dto\User\UserDto;
use App\Service\User\UpdateUserService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/user/{userId}', name: 'deleteUser', methods: ['PUT'])]
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

        $userDto = $serializer->deserialize($request->getContent(), UpdateUserDto::class, 'json');

        try {

            $updateUserService->updateUser($userId, $userDto);

        } catch (NotFoundHttpException $e) {
            $logger->error($e->getMessage());
            return new JsonResponse('User with id: ' . $userId . ' not found', 404);
        } catch (\InvalidArgumentException $e) {
            $logger->error($e->getMessage());
            $errorMessages = json_decode($e->getMessage(), true);
            return new JsonResponse($errorMessages, 409);
        }

        return new JsonResponse(true);
    }
}
