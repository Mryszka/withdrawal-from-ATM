<?php

declare(strict_types = 1);

namespace Withdrawal\Services;

use Withdrawal\Calculators\PayoutCalculator;
use Withdrawal\Helpers\CashHelper;
use Withdrawal\Validators\AmountValidator;

class PayoutService
{

    protected const AVAILABLE_NOMINAL_VALUES = [100, 50, 20, 10];
    protected array $numberOfAvailableBanknotes = [
        100 => 10,
        50 => 10,
        20 => 10,
        10 => 10
    ];

    protected PayoutCalculator $calculator;
    protected AmountValidator $amountValidator;
    protected CashHelper $helper;

    public function __construct ()
    {
        $this->helper = new CashHelper(self::AVAILABLE_NOMINAL_VALUES, $this->numberOfAvailableBanknotes);
        $this -> amountValidator = new AmountValidator($this->helper);
        $this->calculator = new PayoutCalculator($this->helper);
    }

    public function getPayout (int $amount): array
    {
        $this -> amountValidator -> checkAmount($amount);
        $payout = $this -> calculator -> calculatePayout($amount);
        $this->numberOfAvailableBanknotes = $this->helper-> getNumberOfAvailabeBanknotes();

        return $payout;
    }

}
