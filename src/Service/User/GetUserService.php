<?php

namespace App\Service\User;

use App\Dto\User\GetUserDto;
use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class GetUserService
{
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function getUser(int $userId): GetUserDto
    {
        $userEntity = $this->userRepository->find($userId)
            ?? throw new NotFoundHttpException('User with id: ' . $userId . ' not found');

        return new GetUserDto(
            $userEntity->getEmail(),
            $userEntity->getFirstName(),
            $userEntity->getLastName(),
            $userEntity->getRole(),
            $userEntity->getPhoneNumber()
        );
    }

    public function getAllUsers(): array
    {
        $arrOfUsersEntity = $this->userRepository->findAll();

        $arrOfUserDto = [];
        foreach ($arrOfUsersEntity as $userEntity) {
            $arrOfUserDto[] = new GetUserDto(
              $userEntity->getEmail(),
              $userEntity->getFirstName(),
              $userEntity->getLastName(),
              $userEntity->getRole(),
              $userEntity->getPhoneNumber()
            );
        }

        return $arrOfUserDto;
    }
}
