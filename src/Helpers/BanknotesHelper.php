<?php declare(strict_types = 1);

namespace Withdrawal\Helpers;

class BanknotesHelper {
    
    protected array $availableBanknotes;
    
    public function __construct(array $availableBanknotes) {
        rsort($availableBanknotes);
        $this->availableBanknotes = $availableBanknotes;
    }
    
    public function getHighestDenomination(): int
    {
        return $this->availableBanknotes[0];
    }
    
    public function getLowestDenomination(): int
    {
        return $this->availableBanknotes[count($this->availableBanknotes) -1];
    }
}
