<?php

declare(strict_types = 1);

namespace Withdrawal\Validators;

use Withdrawal\Exceptions\NotEnoughNotesException;

class PayoutValidator
{

    /**
     * @throws NotEnoughNotesException
     */
    public function checkPayout (int $maxNumberOfBankNotes, array $payout): void
    {
        if (count($payout) > $maxNumberOfBankNotes) {
            throw new NotEnoughNotesException();
        }
    }

}
