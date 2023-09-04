<?php

declare(strict_types=1);

namespace Withdrawal\Validators;

use Withdrawal\Exceptions\NotEnoughNotesException;

class PayoutValidator {

    public function checkPayout(int $maxNumberOfBanknotes, array $payout): void {
        if (count($payout) > $maxNumberOfBanknotes) {
            throw new NotEnoughNotesException();
        }
    }

}
