<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\Serializer\SerializerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseApiController extends AbstractController
{
    public function __construct(
        protected LoggerInterface $logger,
        protected SerializerInterface $serializer,
    ) {}
}
