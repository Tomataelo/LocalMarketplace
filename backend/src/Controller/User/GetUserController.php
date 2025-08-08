<?php

namespace App\Controller\User;

use App\Controller\BaseApiController;
use App\Service\User\GetUserService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

final class GetUserController extends BaseApiController
{
    #[Route('/api/user/{userId}', name: 'getOneUser', methods: ['GET'])]
    public function getOneUser(int $userId, GetUserService $getUserService): JsonResponse
    {
        try {

            $userDto = $getUserService->getUser($userId);

            $serializedUser = $this->serializer->serialize($userDto, 'json');

        } catch (NotFoundHttpException $e) {
            $this->logger->error($e->getMessage());
            return new JsonResponse(["error" => $e->getMessage()], 404);

        } catch (ExceptionInterface $e) {
            $this->logger->error('Serialization error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Invalid serialization.'], 400);
        }

        return new JsonResponse($serializedUser, 200, [], true);
    }


    #[Route('/api/users', name: 'getAllUsers', methods: ['GET'])]
    public function getAllUsers(GetUserService $getUserService): JsonResponse
    {
        try {

            $arrOfUsers = $getUserService->getAllUsers();

            $serializedUsers = $this->serializer->serialize($arrOfUsers, 'json');

        } catch (NotFoundHttpException $e) {
            $this->logger->error($e->getMessage());
            return new JsonResponse(["error" => $e->getMessage()], 404);

        } catch (ExceptionInterface $e) {
            $this->logger->error('Serialization error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Invalid serialization.'], 400);
        }

        return new JsonResponse($serializedUsers, 200, [], true);
    }
}
