<?php

namespace App\Message;

class NotifyContractorsMessage
{
    public function __construct(public int $orderId) {}
}
