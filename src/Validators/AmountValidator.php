<?php

declare(strict_types = 1);

namespace Withdrawal\Validators;

use Withdrawal\Exceptions\InvalidArgumentException;
use Withdrawal\Exceptions\NotEnoughNotesException;
use Withdrawal\Exceptions\NoteUnavailableException;
use Withdrawal\Helpers\CashHelper;

class AmountValidator
{
    protected CashHelper $cashHelper;
    
    public function __construct (CashHelper $cashHelper)
    {
        $this->cashHelper = $cashHelper;
    }

    /**
     * @throws InvalidArgumentException
     * @throws NotEnoughNotesException
     * @throws NoteUnavailableException
     */
    public function checkAmount (int $amount): void
    {
        $this -> checkAmountIsNotNegativ($amount);
        $this -> checkAmountIsNotBiggerThanMax($amount);
        $this -> checkAmountIsPayable($amount);
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
    protected function checkAmountIsNotBiggerThanMax (int $amount): void
    {
        if ($amount > $this->cashHelper-> getMaxAmount()) {
            throw new NotEnoughNotesException();
        }
    }

    /**
     * @throws NoteUnavailableException
     */
    protected function checkAmountIsPayable (int $amount): void
    {
        if ($amount % $this->cashHelper-> getLowestNominalValue() !== 0) {
            throw new NoteUnavailableException();
        }
    }

}
