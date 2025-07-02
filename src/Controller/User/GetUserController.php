<?php

namespace App\Controller\User;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/api/user/{userId}', name: 'getUser', methods: ['GET'])]
final class GetUserController extends AbstractController
{
    public function __invoke(int $userId): JsonResponse
    {



        return new JsonResponse([]);
    }
}
