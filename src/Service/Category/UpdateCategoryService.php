<?php

namespace App\Service\Category;

use App\Dto\Category\UpdateCategoryDto;
use App\Exception\ValidationException;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class UpdateCategoryService
{
    public function __construct(
        private CategoryRepository $categoryRepository,
        private EntityManagerInterface $entityManager
    ){}

    public function __invoke(int $categoryId, UpdateCategoryDto $updateCategoryDto)
    {
        $categoryEntity = $this->categoryRepository->find($categoryId)
            ?? throw new NotFoundHttpException("Category with id: ". $categoryId ." Not Found");

        if (!is_null($updateCategoryDto->getName()) && $updateCategoryDto->getName() !== $categoryEntity->getName()) {
            $categoryEntity->setName($updateCategoryDto->getName());
        }

        if (!is_null($updateCategoryDto->getSlug()) && $updateCategoryDto->getSlug() !== $categoryEntity->getSlug()) {
            $categoryEntity->setSlug($updateCategoryDto->getSlug());
        }

        $this->entityManager->flush();

        return true;
    }
}
