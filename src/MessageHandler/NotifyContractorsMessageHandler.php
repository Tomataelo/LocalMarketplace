<?php

namespace App\MessageHandler;

use App\Message\NotifyContractorsMessage;
use App\Repository\CategoryRepository;
use App\Repository\ContractorServiceRepository;
use App\Repository\CustomerOrderRepository;
use App\Service\Mailer\ContractorMailer;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class NotifyContractorsMessageHandler
{
    public function __construct(
        private LoggerInterface $logger,
        private ContractorMailer  $contractorMailer,
        private CustomerOrderRepository $customerOrderRepository,
        private ContractorServiceRepository $contractorServiceRepository,
    ){}

    public function __invoke(NotifyContractorsMessage $message): void
    {
        $customerOrderEntity = $this->customerOrderRepository->find($message->orderId);

        $customerEntity = $customerOrderEntity->getClient();
        $fullName = $customerEntity->getFirstName() + $customerEntity->getLastName();

        $categoryEntity = $customerOrderEntity->getCategory();
        $categoryId = $categoryEntity->getId();

        $this->contractorMailer->sendNotification($fullName);

        $this->logger->info(var_export($fullName, true));

    }
}
