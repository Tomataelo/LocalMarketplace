<?php

namespace App\MessageHandler;

use App\Message\NotifyContractorsMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class NotifyContractorsMessageHandler
{
    public function __invoke(NotifyContractorsMessage $message): void
    {

    }
}
