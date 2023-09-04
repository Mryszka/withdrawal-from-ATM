<?php

declare(strict_types = 1);

namespace Withdrawal\Calculators;

use Withdrawal\Exceptions\NoteUnavailableException;

class PayoutCalculator
{

    protected int $iterator = 0;
    protected array $bankNotes = [];
    protected array $availableNominalValues;

    public function __construct (array $availableNominalValues)
    {
        rsort($availableNominalValues);
        $this -> availableNominalValues = $availableNominalValues;
    }

    public function calculatePayout (int $unpaydAmound): array
    {

        $nominalValue = $this -> getFirstNominalValue();

        while ($unpaydAmound > 0) {
            if ($unpaydAmound < $nominalValue) {
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
            throw new NoteUnavailableException();
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
        return $unpaydAmound - $nominalValue;
    }

}
