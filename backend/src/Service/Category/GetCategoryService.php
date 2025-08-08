<?php

namespace App\Service\Category;

use App\Dto\Category\CategoryDto;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class GetCategoryService
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {}

    public function getCategory(int $categoryId, $returnEntity = false): CategoryDto|Category
    {
        $categoryEntity = $this->categoryRepository->find($categoryId)
            ?? throw new NotFoundHttpException('Category with id: ' . $categoryId . ' not found');

        if ($returnEntity) {
            return $categoryEntity;
        }

        return new CategoryDto(
            $categoryEntity->getName(),
            $categoryEntity->getSlug()
        );
    }


    public function getAllCategories(): array
    {
        $arrOfCategoryEntity = $this->categoryRepository->findAll();

        $arrOfCategoriesDto = [];
        foreach ($arrOfCategoryEntity as $categoryEntity) {
            $arrOfCategoriesDto[] = new CategoryDto(
                $categoryEntity->getName(),
                $categoryEntity->getSlug(),
            );
        }

        return $arrOfCategoriesDto;
    }
}
