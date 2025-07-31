<?php

namespace App\Controller\User;

use App\Exception\ValidationException;
use App\Dto\User\CreateUserDto;
use App\Service\User\CreateUserService;
use App\Controller\BaseApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

#[Route('/api/user', name: 'createUser', methods: ['POST'])]
final class CreateUserController extends BaseApiController
{
    public function __invoke(Request $request, CreateUserService $userService): JsonResponse
    {
        try {

            $createUserDto = $this->serializer->deserialize($request->getContent(), CreateUserDto::class, 'json');

            $userService->createUser($createUserDto);

            $serializedUser = $this->serializer->serialize($createUserDto, 'json');

        } catch (ExceptionInterface $e) {
            $this->logger->error('Deserialization error: ' . $e->getMessage());
            return new JsonResponse(['error' => 'Invalid input. Please ensure all required fields are entered correctly.'], 400);

        } catch (ValidationException $e) {
            $this->logger->error($e->getMessage());
            return new JsonResponse(["errors" => json_decode($e->getMessage() , true)], 422);

        } catch (\InvalidArgumentException $e) {
            $this->logger->error($e->getMessage());
            return new JsonResponse(['error' => $e->getMessage()], 409);
        }

        return new JsonResponse($serializedUser, 201, [], true);
    }
}
