<?php

namespace App\Controller\User;

use App\Controller\BaseApiController;
use App\Service\User\RemoveUserService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user/{userId}', name: 'deleteUser', methods: ['DELETE'])]
final class RemoveUserController extends BaseApiController
{
    public function __invoke(int $userId, RemoveUserService $removeUserService): JsonResponse
    {
        try {

            $removeUserService->removeUser($userId);

        } catch (NotFoundHttpException $e) {
            $this->logger->info($e->getMessage());
            return new JsonResponse([json_decode($e->getMessage())]);
        }

        return new JsonResponse(["success" => true]);
    }
}

