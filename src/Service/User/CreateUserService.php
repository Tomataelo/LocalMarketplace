<?php

namespace App\Service\User;

use App\Dto\User\CreateUserDto;
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

    public function createUser(CreateUserDto $createUserDto): void
    {
        $errors = $this->validator->validate($createUserDto);

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

        $isUserExist = $this->userRepository->findBy(['email' => $createUserDto->getEmail()]);
        if ($isUserExist) {
            throw new \InvalidArgumentException('User with this email already exist');
        }


        $user = new User();
        $user->setEmail($createUserDto->getEmail());
        $user->setPassword($createUserDto->getPassword());
        $user->setFirstName($createUserDto->getFirstName());
        $user->setLastName($createUserDto->getLastName());
        $user->setRole($createUserDto->getRole());
        $user->setPhoneNumber($createUserDto->getPhoneNumber());

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
