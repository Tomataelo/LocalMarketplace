<?php

namespace App\Controller\User;

use App\Dto\User\UserDto;
use App\Service\User\CreateUserService;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/user', name: 'createUser', methods: ['POST'])]
final class CreateUserController extends AbstractController
{
    public function __invoke(
        Request $request,
        SerializerInterface $serializer,
        LoggerInterface $logger,
        CreateUserService $userService,
    ): JsonResponse
    {
        try {

            $userDto = $serializer->deserialize($request->getContent(), UserDto::class, 'json');

            $userService->createUser($userDto);

        } catch (ExceptionInterface $e) {
            $logger->error($e->getMessage());
            return new JsonResponse($e->getMessage(), 400);

        } catch (\InvalidArgumentException $e) {
            $logger->error($e->getMessage());
            $errorMessages = json_decode($e->getMessage(), true);
            return new JsonResponse($errorMessages, 409);
        }

        return new JsonResponse($userDto, 201);
    }
}
