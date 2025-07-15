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

#[Route('/api/user/{userId}', name: 'getUser', methods: ['GET'])]
final class GetUserController extends AbstractController
{
    public function __invoke(
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
            return new JsonResponse('User with id: ' . $userId . ' not found', 404);

        } catch (ExceptionInterface $e) {
            $logger->error($e->getMessage());
            return new JsonResponse($e->getMessage(), 500);
        }

        return new JsonResponse($serializedUser, 200, [], true);
    }
}
