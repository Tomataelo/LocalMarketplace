<?php

namespace App\Service\User;

use App\Dto\User\UpdateUserDto;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

use App\Exception\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class UpdateUserService
{
    public function __construct(
        private ValidatorInterface $validator,
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager
    ){}

    public function updateUser(int $userId, UpdateUserDto $userDto): bool
    {
        $userEntity = $this->userRepository->find($userId)
            ?? throw new NotFoundHttpException('User with id: ' . $userId . ' not found');

        $errors = $this->validator->validate($userDto);

        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = [
                    'field' => $error->getPropertyPath(),
                    'message' => $error->getMessage()
                ];
            }

            throw new ValidationException(json_encode($errorMessages));
        }

        if (!is_null($userDto->getEmail()) && $userDto->getEmail() !== $userEntity->getEmail()) {
            $userEntity->setEmail($userDto->getEmail());
        }

        if (!is_null($userDto->getPassword()) && $userDto->getPassword() !== $userEntity->getPassword()) {
            $userEntity->setPassword($userDto->getPassword());
        }

        if (!is_null($userDto->getFirstName()) && $userDto->getFirstName() !== $userEntity->getFirstName()) {
            $userEntity->setFirstName($userDto->getFirstName());
        }

        if (!is_null($userDto->getLastName()) && $userDto->getLastName() !== $userEntity->getLastName()) {
            $userEntity->setLastName($userDto->getLastName());
        }

        if (!is_null($userDto->getRole()) && $userDto->getRole() !== $userEntity->getRole()) {
            $userEntity->setRole($userDto->getRole());
        }

        if (!is_null($userDto->getPhoneNumber()) && $userDto->getPhoneNumber() !== $userEntity->getPhoneNumber()) {
            $userEntity->setPhoneNumber($userDto->getPhoneNumber());
        }

        $this->entityManager->flush();

        return true;
    }
}
