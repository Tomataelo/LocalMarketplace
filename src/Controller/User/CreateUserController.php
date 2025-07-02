<?php

namespace App\Controller\User;

use App\Dto\UserDto;
use App\Service\User\CreateUserService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/user', name: 'createUser', methods: ['POST'])]
final class CreateUserController extends AbstractController
{
    public function __invoke(Request $request, SerializerInterface $serializer, LoggerInterface $logger, CreateUserService $createUser): JsonResponse
    {

        try {

            $dto = $serializer->deserialize($request->getContent(), UserDto::class, 'json');
            $createUser->createUser($dto);

        } catch (ExceptionInterface $e) {
            $logger->error($e->getMessage());
            return new JsonResponse(['error' => 'Invalid request data'], 400);
        }

        return new JsonResponse([
            "request" => $dto
        ]);
    }
}
