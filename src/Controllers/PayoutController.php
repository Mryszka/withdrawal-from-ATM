<?php

declare(strict_types = 1);

namespace Withdrawal\Controllers;

use Withdrawal\Services\PayoutService;

class PayoutController
{

    protected PayoutService $service;

    public function __construct (PayoutService $service)
    {
        $this -> service = $service;
    }

    public function getPayout ($amount): array
    {
        return $this -> service -> getPayout((int) $amount);
    }

}
