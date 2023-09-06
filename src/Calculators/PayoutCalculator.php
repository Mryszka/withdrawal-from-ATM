<?php

declare(strict_types = 1);

namespace Withdrawal\Calculators;

use Withdrawal\Exceptions\NotEnoughNotesException;

class PayoutCalculator
{

    protected int $iterator = 0;
    protected array $bankNotes = [];
    protected array $availableNominalValues;
    protected array $availableBankNote;

    public function __construct (array $availableNominalValues, array $availableBankNote)
    {
        rsort($availableNominalValues);
        $this -> availableNominalValues = $availableNominalValues;
        $this-> availableBankNote = $availableBankNote;
    }

    public function calculatePayout (int $unpaydAmound): array
    {
        $this->bankNotes = [];    
        $nominalValue = $this -> getFirstNominalValue();

        while ($unpaydAmound > 0) {
            if ($unpaydAmound < $nominalValue || $this->availableBankNote[$nominalValue] < 1) {
                $nominalValue = $this -> getNextNominalValue();
            } else {
                $unpaydAmound = $this -> withdrawBankNote($nominalValue, $unpaydAmound);
            }
        }

        return $this -> bankNotes;
    }

    protected function getNextNominalValue (): int
    {
        $this -> iterator++;
        if (!isset($this -> availableNominalValues[$this -> iterator])) {
            throw new NotEnoughNotesException();
        }
        return $this -> availableNominalValues[$this -> iterator];
    }

    protected function getFirstNominalValue (): int
    {
        return $this -> availableNominalValues[0];
    }

    protected function withdrawBankNote (int $nominalValue, int $unpaydAmound): int
    {
        $this -> bankNotes[] = $nominalValue;
        $this->availableBankNote[$nominalValue] --;
        return $unpaydAmound - $nominalValue;
    }
    
    public function getChangedAvailableNumberOfBankNote(): array
    {
        return $this->availableBankNote;
    }
    

}
