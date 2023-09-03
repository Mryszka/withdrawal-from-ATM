<?php declare(strict_types = 1);

namespace WithdrawalTest\Calculators;

use PHPUnit\Framework\TestCase;
use Withdrawal\Calculators\PayoutCalculator;

class PayoutCalculatorTest extends TestCase
{
    
    protected const AVAILABLE_BANKNOTES = [100, 50, 20, 10];
    
    protected PayoutCalculator $calculator;
    
    public function setUp(): void {
        $this->calculator = new PayoutCalculator();
    }
    
     /**
     * @dataProvider calculatePayoutProvider
     */
    public function testCalculatePayout(int $sum, array $expectedPayout) {
        
        $this->assertSame(
            $expectedPayout, 
            $this->calculator->calculatePayout($sum, self::AVAILABLE_BANKNOTES) 
        );
    }
    
    public static function calculatePayoutProvider()
    {
        yield [0, []];
        yield [10, [10]];
        yield [30, [20, 10]];
        yield [80, [50, 20, 10]];
        yield [230, [100, 100, 20, 10]];
        yield [400, [100, 100, 100, 100]];
    }
}
