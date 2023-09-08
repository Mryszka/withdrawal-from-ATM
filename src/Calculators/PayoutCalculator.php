<?php

declare(strict_types = 1);

namespace Withdrawal\Calculators;

use Withdrawal\Helpers\CashHelper;

class PayoutCalculator
{
    protected CashHelper $cashHelper;

    public function __construct (CashHelper $cashHelper)
    {
        $this -> cashHelper = $cashHelper;
    }

    public function calculatePayout (int $unpaydAmound): array
    {
        $bankNotes = [];
        $nominalValue = $this -> cashHelper -> getFirstNominalValue();

        while ($unpaydAmound > 0) {
            if ($unpaydAmound < $nominalValue) {
                $nominalValue = $this -> cashHelper -> getNextNominalValueDesc($nominalValue);
            } else {
                $unpaydAmound -= $nominalValue;
                $bankNotes[] = $nominalValue;
                $this -> cashHelper -> decreaseNumberOfAvailableBanknotes($nominalValue);
            }
        }

        return $bankNotes;
    }

}
