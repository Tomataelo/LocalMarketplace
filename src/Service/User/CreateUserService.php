<?php

namespace App\Service\User;

use App\Dto\User\UserDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Exception\ValidationException;


readonly class CreateUserService
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager,
        private ValidatorInterface     $validator
    ){}

    public function createUser(UserDto $userDto): void
    {
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

        $isUserExist = $this->userRepository->findBy(['email' => $userDto->getEmail()]);
        if ($isUserExist) {
            throw new \InvalidArgumentException('User with this email already exist');
        }


        $user = new User();
        $user->setEmail($userDto->getEmail());
        $user->setPassword($userDto->getPassword());
        $user->setFirstName($userDto->getFirstName());
        $user->setLastName($userDto->getLastName());
        $user->setRole($userDto->getRole());
        $user->setPhoneNumber($userDto->getPhoneNumber());

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
