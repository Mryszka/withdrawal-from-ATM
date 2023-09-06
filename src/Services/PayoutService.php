<?php

declare(strict_types = 1);

namespace Withdrawal\Services;

use Withdrawal\Calculators\PayoutCalculator;
use Withdrawal\Helpers\NominalValueHelper;
use Withdrawal\Validators\AmountValidator;
use Withdrawal\Validators\PayoutValidator;

class PayoutService
{

    protected const AVAILABLE_NOMINAL_VALUES = [100, 50, 20, 10];
    protected const MAX_NUMBER_OF_BANK_NOTES = 10;
    public array $numberOfAvailableBanknotes = [
        100 => 10,
        50 => 10,
        20 => 10,
        10 => 10
    ];

    protected PayoutCalculator $calculator;
    protected NominalValueHelper $helper;
    protected AmountValidator $amountValidator;
    protected PayoutValidator $payoutValidator;

    public function __construct (
        AmountValidator $amountValidator,
        PayoutValidator $payoutValidator
    )
    {
        $this -> amountValidator = $amountValidator;
        $this -> payoutValidator = $payoutValidator;

        $this -> calculator = new PayoutCalculator(self::AVAILABLE_NOMINAL_VALUES, $this->numberOfAvailableBanknotes);
        $this -> helper = new NominalValueHelper(self::AVAILABLE_NOMINAL_VALUES);
    }

    public function getPayout (int $amount): array
    {
        $this -> amountValidator -> checkAmount(
            $amount,
            $this->numberOfAvailableBanknotes,
            $this -> helper -> getHighestNominalValue(),
            $this -> helper -> getLowestNominalValue()
        );

        $payout = $this -> calculator -> calculatePayout($amount);

       $this->numberOfAvailableBanknotes = $this->calculator-> getChangedAvailableNumberOfBankNote();

        return $payout;
    }

}
