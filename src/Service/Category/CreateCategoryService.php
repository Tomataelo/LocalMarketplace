<?php

namespace App\Service\Category;

use App\Dto\Category\CategoryDto;
use App\Entity\Category;
use App\Exception\ValidationException;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CreateCategoryService
{

    public function __construct(
        private CategoryRepository $categoryRepository,
        private EntityManagerInterface    $entityManager,
        private ValidatorInterface        $validator
    ){}

    public function __invoke(CategoryDto $serviceCategoryDto): CategoryDto
    {
        $errors = $this->validator->validate($serviceCategoryDto);

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

        $isServiceCategoryNameExists = $this->categoryRepository->findOneBy(['name' => $serviceCategoryDto->getName()]);
        if ($isServiceCategoryNameExists) {
            throw new \InvalidArgumentException('Category with this name already exist');
        }

        $isServiceCategorySlugExists = $this->categoryRepository->findOneBy(['slug' => $serviceCategoryDto->getSlug()]);
        if ($isServiceCategorySlugExists) {
            throw new \InvalidArgumentException('Category with this slug already exist');
        }


        $serviceCategory = new Category();
        $serviceCategory->setName($serviceCategoryDto->getName());
        $serviceCategory->setSlug($serviceCategoryDto->getSlug());

        $this->entityManager->persist($serviceCategory);
        $this->entityManager->flush();

        return $serviceCategoryDto;
    }
}
