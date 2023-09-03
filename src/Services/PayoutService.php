<?php declare(strict_types = 1);

namespace Withdrawal\Services;

use Withdrawal\Calculators\PayoutCalculator;
use Withdrawal\Helpers\BanknotesHelper;
use Withdrawal\Validators\AmountValidator;
use Withdrawal\Validators\PayoutValidator;

class PayoutService {
    
    protected const AVAILABLE_BANKNOTES = [100, 50, 20, 10];
    protected const MAX_NUMBER_OF_BANKONTES = 10;
    
    protected PayoutCalculator $calculator;
    protected BanknotesHelper $helper;
    protected AmountValidator $amountValidator;
    protected PayoutValidator $payoutValidator;
  
    public function __construct(
        PayoutCalculator $calculator,
        AmountValidator $amountValidator,
        PayoutValidator $payoutValidator
    ) {
        $this->calculator = $calculator;
        $this->amountValidator = $amountValidator;
        $this->payoutValidator = $payoutValidator;
        
        $this->helper = new BanknotesHelper(self::AVAILABLE_BANKNOTES);
    }
    public function getPayout(int $sum): array 
    {
        $this->amountValidator->checkAmount(
            $sum, 
            self::MAX_NUMBER_OF_BANKONTES, 
            $this->helper->getHighestDenomination(), 
            $this->helper->getLowestDenomination()
        );
        
        $payout = $this->calculator->calculatePayout($sum, self::AVAILABLE_BANKNOTES);
        
        $this->payoutValidator->checkPayout(self::MAX_NUMBER_OF_BANKONTES, $payout);
        
        return $payout;
    }
}
