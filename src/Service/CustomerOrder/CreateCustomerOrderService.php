<?php

namespace App\Service\CustomerOrder;

use App\Service\Province\GetProvinceService;
use App\Service\User\GetUserService;
use App\Service\Category\GetCategoryService;
use App\Dto\CustomerOrder\CreateCustomerOrderDto;
use App\Entity\CustomerOrder;
use App\Exception\ValidationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class CreateCustomerOrderService
{
    public function __construct(
        private GetUserService         $getUserService,
        private GetCategoryService     $getCategoryService,
        private GetProvinceService     $getProvinceService,
        private EntityManagerInterface $entityManager,
        private ValidatorInterface     $validator
    ){}

    public function createCustomerOrder(CreateCustomerOrderDto $customerOrderDto): int
    {
        $errors = $this->validator->validate($customerOrderDto);

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

        $clientEntity = $this->getUserService->getUser($customerOrderDto->getClientId(), true);
        $categoryEntity = $this->getCategoryService->getCategory($customerOrderDto->getCategoryId(), true);
        $provinceEntity = $this->getProvinceService->getProvince($customerOrderDto->getProvinceId());

        $customerOrder = new CustomerOrder();
        $customerOrder->setClient($clientEntity);
        $customerOrder->setCategory($categoryEntity);
        $customerOrder->setTitle($customerOrderDto->getTitle());
        $customerOrder->setDescription($customerOrderDto->getDescription());
        $customerOrder->setPreferredDate($customerOrderDto->getPreferredDate());
        $customerOrder->setCity($customerOrderDto->getCity());
        $customerOrder->setAddress($customerOrderDto->getAddress());
        $customerOrder->setPostalCode($customerOrderDto->getPostalCode());
        $customerOrder->setProvince($provinceEntity);

        $this->entityManager->persist($customerOrder);
        $this->entityManager->flush();

        return $customerOrder->getId();
    }
}
