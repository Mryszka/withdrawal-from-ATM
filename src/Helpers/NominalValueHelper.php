<?php

declare(strict_types = 1);

namespace Withdrawal\Helpers;

class NominalValueHelper
{

    protected array $availableNominalValues;

    public function __construct (array $availableNominalValues)
    {
        rsort($availableNominalValues);
        $this -> availableNominalValues = $availableNominalValues;
    }

    public function getHighestNominalValue (): int
    {
        return $this -> availableNominalValues[0];
    }

    public function getLowestNominalValue (): int
    {
        return $this -> availableNominalValues[count($this -> availableNominalValues) - 1];
    }

}
