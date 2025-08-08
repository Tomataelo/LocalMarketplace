<?php

namespace App\Service\Province;

use App\Entity\Province;
use App\Repository\ProvinceRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class GetProvinceService
{
    public function __construct(
        private ProvinceRepository $provinceRepository
    ){}

    public function getProvince(int $provinceId): Province
    {
        return $this->provinceRepository->find($provinceId)
            ?? throw new NotFoundHttpException("Province with id: ". $provinceId ."not found");
    }
}
