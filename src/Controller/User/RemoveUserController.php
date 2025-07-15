<?php

namespace App\Controller\User;

use App\Service\User\RemoveUserService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user/{userId}', name: 'deleteUser', methods: ['DELETE'])]
final class RemoveUserController extends AbstractController
{
    public function __invoke(
        int $userId,
        LoggerInterface $logger,
        RemoveUserService $removeUserService
    ): JsonResponse
    {
        try {

            $removeUserService->removeUser($userId);
            
        } catch (NotFoundHttpException $e) {

            $logger->info($e->getMessage());
            return new JsonResponse([json_decode($e->getMessage())]);
        }

        return new JsonResponse(true);
    }
}

