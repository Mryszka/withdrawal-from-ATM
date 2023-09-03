<?php declare(strict_types = 1);

namespace WithdrawalTest\Helpers;

use PHPUnit\Framework\TestCase;
use Withdrawal\Helpers\BanknotesHelper;

class BanknotesHelperTest extends TestCase{
    
    /**
     * @dataProvider banknotesHigestHelperProvider
     */
    public function testGetHighestDenomination(array $availableBanknotes, int $expectedResult)
    {
        $helper = new BanknotesHelper($availableBanknotes);
        $this->assertSame(
            $expectedResult, 
            $helper->getHighestDenomination() 
        );
    }
    
    /**
     * @dataProvider banknotesLowestHelperProvider
     */
    public function testGetLowestDenomination(array $availableBanknotes, int $expectedResult)
    {
        $helper = new BanknotesHelper($availableBanknotes);
        $this->assertSame(
            $expectedResult, 
            $helper->getLowestDenomination() 
        );
    }
    
    public static function banknotesHigestHelperProvider()
    {
        yield [[100, 30 ,50], 100];
        yield [[20], 20];
        yield [[50, 10, 100, 20], 100];
    }
    
    public static function banknotesLowestHelperProvider()
    {
        yield [[100, 30 ,50],  30];
        yield [[20], 20];
        yield [[50, 10, 100, 20], 10];
    }
}
