<?php

declare(strict_types = 1);

namespace Withdrawal\Validators;

use Withdrawal\Exceptions\InvalidArgumentException;
use Withdrawal\Exceptions\NotEnoughNotesException;
use Withdrawal\Exceptions\NoteUnavailableException;

class AmountValidator
{

    /**
     * @throws InvalidArgumentException
     * @throws NotEnoughNotesException
     * @throws NoteUnavailableException
     */
    public function checkAmount (
        int $amount,
        int $maxNumberOfBankNotes,
        int $highestNominalValue,
        int $lowestNominalValue
    ): void
    {
        $this -> checkAmountIsNotNegativ($amount);
        $this -> checkAmountIsNotBiggerThanMax(
            $amount,
            $this -> getMaxAmount($maxNumberOfBankNotes, $highestNominalValue)
        );
        $this -> checkAmountIsPayable($amount, $lowestNominalValue);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function checkAmountIsNotNegativ (int $amount): void
    {
        if ($amount < 0) {
            throw new InvalidArgumentException();
        }
    }

    /**
     * @throws NotEnoughNotesException
     */
    protected function checkAmountIsNotBiggerThanMax (int $amount, int $maxAmount): void
    {
        if ($amount > $maxAmount) {
            throw new NotEnoughNotesException();
        }
    }

    protected function getMaxAmount (int $maxNumberOfBankNotes, int $highestNominalValue): int
    {
        return $maxNumberOfBankNotes * $highestNominalValue;
    }

    /**
     * @throws NoteUnavailableException
     */
    protected function checkAmountIsPayable (int $amount, int $lowestNominalValue): void
    {
        if ($amount % $lowestNominalValue !== 0) {
            throw new NoteUnavailableException();
        }
    }

}
