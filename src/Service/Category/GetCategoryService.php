<?php

namespace App\Service\Category;

use App\Dto\Category\CategoryDto;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class GetCategoryService
{
    public function __construct(
        private CategoryRepository $categoryRepository
    ) {}

    public function getCategory(int $categoryId): CategoryDto
    {
        $serviceCategoryEntity = $this->categoryRepository->find($categoryId)
            ?? throw new NotFoundHttpException('Service Category with id: ' . $categoryId . ' not found');

        return new CategoryDto(
            $serviceCategoryEntity->getName(),
            $serviceCategoryEntity->getSlug()
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
