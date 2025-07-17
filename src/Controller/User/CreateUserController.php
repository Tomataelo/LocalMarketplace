<?php

namespace App\Controller\User;

use App\Exception\ValidationException;
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

            $serializedUser = $serializer->serialize($userDto, 'json');

        } catch (ExceptionInterface $e) {
            $logger->error('Deserialization error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Invalid input. Please ensure all required fields are entered correctly.'], 400);

        } catch (ValidationException $e) {
            $logger->error($e->getMessage());
            return new JsonResponse(["errors" => json_decode($e->getMessage() , true)], 422);

        } catch (\InvalidArgumentException $e) {
            $logger->error($e->getMessage());
            return new JsonResponse(['error' => $e->getMessage()], 409);
        }

        return new JsonResponse($serializedUser, 201, [], true);
    }
}
