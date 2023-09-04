<?php

declare(strict_types=1);

namespace Withdrawal\Validators;

use Withdrawal\Exceptions\InvalidArgumentException;
use Withdrawal\Exceptions\NotEnoughNotesException;
use Withdrawal\Exceptions\NoteUnavailableException;

class AmountValidator {

    public function checkAmount(
            int $sum,
            int $maxNumberOfBanknotes,
            int $highestDenomination,
            int $lowestDenomination
    ): void {
        $this->checkAmountIsNotNegativ($sum);
        $this->checkAmountIsNotBiggerThanMax(
                $sum,
                $this->maxAmount($maxNumberOfBanknotes, $highestDenomination)
        );
        $this->checkAmountIsPayable($sum, $lowestDenomination);
    }

    protected function checkAmountIsNotNegativ(int $sum): void {
        if ($sum < 0) {
            throw new InvalidArgumentException();
        }
    }

    protected function checkAmountIsNotBiggerThanMax(int $sum, int $max): void {
        if ($sum > $max) {
            throw new NotEnoughNotesException();
        }
    }

    protected function maxAmount(int $maxNumberOfBanknotes, int $highestDenomination): int {
        return $maxNumberOfBanknotes * $highestDenomination;
    }

    protected function checkAmountIsPayable(int $sum, int $lowestDenomination): void {
        if ($sum % $lowestDenomination !== 0) {
            throw new NoteUnavailableException();
        }
    }

}
