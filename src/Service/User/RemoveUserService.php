<?php

namespace App\Service\User;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class RemoveUserService
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager
    ) {}

    public function removeUser(int $userId): void
    {
        $userEntity = $this->userRepository->find($userId);

        if (!$userEntity) {
            throw new NotFoundHttpException('User with id: ' .$userId. ' not found.');
        }

        $this->entityManager->remove($userEntity);
        $this->entityManager->flush();
    }

}
