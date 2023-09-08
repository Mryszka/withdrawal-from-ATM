<?php

declare(strict_types = 1);

namespace Withdrawal\Helpers;

use Withdrawal\Exceptions\NotEnoughNotesException;

class CashHelper
{

    protected array $availableNominalValues;
    protected array $numberOfAvailableBanknotes;

    public function __construct (array $availableNominalValues, array $numberOfAvailableBanknotes)
    {
        rsort($availableNominalValues);
        $this -> availableNominalValues = $availableNominalValues;
        $this -> numberOfAvailableBanknotes = $numberOfAvailableBanknotes;
    }

    /**
     * @throws NotEnoughNotesException
     */
    public function getLowestNominalValue (): int
    {
        $iterator = count($this -> availableNominalValues);
        while ($iterator > 0) {
            $iterator--;
            $nominalValue = $this -> availableNominalValues[$iterator];
            if ($this -> numberOfAvailableBanknotes[$nominalValue] > 0) {
                return $nominalValue;
            }
        }

        throw new NotEnoughNotesException();
    }

    /**
     * @throws NotEnoughNotesException
     */
    public function getFirstNominalValue (): int
    {
        return $this -> getHigestNominalValue(0);
    }

    /**
     * @throws NotEnoughNotesException
     */
    protected function getHigestNominalValue (int $iterator): int
    {
        $max = count($this -> availableNominalValues);
        while ($iterator < $max) {

            $nominalValue = $this -> availableNominalValues[$iterator];
            if ($this -> numberOfAvailableBanknotes[$nominalValue] > 0) {
                return $nominalValue;
            }
            $iterator++;
        }

        throw new NotEnoughNotesException();
    }

    /**
     * @throws NotEnoughNotesException
     */
    public function getNextNominalValueDesc (int $nominalValue): int
    {
        $iterator = array_search($nominalValue, $this -> availableNominalValues);
        $iterator++;
        return $this -> getHigestNominalValue($iterator);
    }

    public function getMaxAmount (): int
    {
        $maxAmount = 0;
        foreach ($this -> numberOfAvailableBanknotes as $number => $value) {
            $maxAmount += $number * $value;
        }
        return $maxAmount;
    }

    public function decreaseNumberOfAvailableBanknotes (int $nominalValue)
    {
        $this -> numberOfAvailableBanknotes[$nominalValue]--;
    }

    public function getNumberOfAvailabeBanknotes (): array
    {
        return $this -> numberOfAvailableBanknotes;
    }

}
