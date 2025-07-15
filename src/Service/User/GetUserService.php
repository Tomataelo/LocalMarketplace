<?php

namespace App\Service\User;

use App\Dto\User\UserDto;
use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class GetUserService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function getUser(int $userId): UserDto
    {
        $userEntity = $this->userRepository->find($userId);

        if (!$userEntity) {
            throw new NotFoundHttpException('User not found.');
        }

        return new UserDto(
            $userEntity->getEmail(),
            $userEntity->getPassword(),
            $userEntity->getFirstName(),
            $userEntity->getLastName(),
            $userEntity->getRole(),
            $userEntity->getPhoneNumber()
        );
    }
}
