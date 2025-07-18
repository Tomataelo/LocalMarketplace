<?php

namespace App\Controller\User;

use App\Service\User\GetUserService;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class GetUserController extends AbstractController
{
    #[Route('/api/user/{userId}', name: 'getUser', methods: ['GET'])]
    public function getOneUser(
        int $userId,
        SerializerInterface $serializer,
        LoggerInterface $logger,
        GetUserService $getUserService
    ): JsonResponse
    {
        try {

            $userDto = $getUserService->getUser($userId);

            $serializedUser = $serializer->serialize($userDto, 'json');

        } catch (NotFoundHttpException $e) {
            $logger->error($e->getMessage());
            return new JsonResponse(["error" => $e->getMessage()], 404);

        } catch (ExceptionInterface $e) {
            $logger->error('Serialization error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Invalid serialization.'], 400);
        }

        return new JsonResponse($serializedUser, 200, [], true);
    }


    #[Route('/api/users', name: 'getUsers', methods: ['GET'])]
    public function getUsers(
        SerializerInterface $serializer,
        LoggerInterface $logger,
        GetUserService $getUserService
    ): JsonResponse
    {
        try {

            $arrOfUsers = $getUserService->getAllUsers();

            $serializedUsers = $serializer->serialize($arrOfUsers, 'json');

        } catch (NotFoundHttpException $e) {
            $logger->error($e->getMessage());
            return new JsonResponse(["error" => $e->getMessage()], 404);

        } catch (ExceptionInterface $e) {
            $logger->error('Serialization error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Invalid serialization.'], 400);
        }

        return new JsonResponse($serializedUsers, 200, [], true);
    }
}
