<?php

namespace App\Service\Category;

use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class RemoveCategoryService
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private EntityManagerInterface    $entityManager
    ){}

    public function __invoke(int $categoryId): void
    {
        $categoryEntity = $this->categoryRepository->find($categoryId)
            ?? throw new NotFoundHttpException('User with id: ' . $categoryId . ' not found');

        $this->entityManager->remove($categoryEntity);
        $this->entityManager->flush();
    }
}
