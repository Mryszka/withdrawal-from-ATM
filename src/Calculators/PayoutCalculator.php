<?php

declare(strict_types=1);

namespace Withdrawal\Calculators;

class PayoutCalculator {

    protected int $iterator;
    protected array $result = [];
    protected array $banknotes;

    public function calculatePayout(int $unpaydAmound, array $banknotes): array {
        $this->prepareBanknoteToWithdraw($banknotes);
        $banknote = $this->getFirstBanknote();

        while ($unpaydAmound > 0) {
            if ($unpaydAmound < $banknote) {
                $banknote = $this->getNextBanknote();
            } else {
                $unpaydAmound = $this->withdrawBanknote($banknote, $unpaydAmound);
            }
        }

        return $this->result;
    }

    protected function getNextBanknote(): int {
        $this->iterator++;
        return $this->banknotes[$this->iterator];
    }

    protected function prepareBanknoteToWithdraw(array $banknotes): void {
        $this->iterator = 0;
        rsort($banknotes);
        $this->banknotes = $banknotes;
    }

    protected function getFirstBanknote(): int {
        return $this->banknotes[0];
    }

    protected function withdrawBanknote(int $banknote, int $unpaydAmound): int {
        $this->result[] = $banknote;
        return $unpaydAmound - $banknote;
    }

}
