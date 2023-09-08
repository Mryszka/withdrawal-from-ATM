<?php

declare(strict_types = 1);

namespace WithdrawalTest\Calculators;

use PHPUnit\Framework\TestCase;
use Withdrawal\Calculators\PayoutCalculator;
use Withdrawal\Helpers\CashHelper;
use PHPUnit\Framework\MockObject\MockObject;

class PayoutCalculatorTest extends TestCase
{

    protected PayoutCalculator $calculator;
    protected MockObject | CashHelper $helper;

    public function setUp (): void
    {
        $this -> helper = $this -> createMock(CashHelper::class);
        $this -> calculator = new PayoutCalculator($this -> helper);
    }

    public function testCalculatePayoutForZeroAmount ()
    {
        $this -> helper -> method('getFirstNominalValue') -> willReturn(10);
        $this -> assertSame(
            [],
            $this -> calculator -> calculatePayout(0)
        );
    }

    public function testCalculatePayoutWithOneNominalValue ()
    {
        $this -> helper -> method('getFirstNominalValue') -> willReturn(100);
        $this -> assertSame(
            [100, 100],
            $this -> calculator -> calculatePayout(200)
        );
    }

    public function testCalculatePayoutWithMoreThanOneNominalValue ()
    {
        $this -> helper -> method('getFirstNominalValue') -> willReturn(100);
        $this -> helper -> method('getNextNominalValueDesc') -> willReturn(50);
        $this -> assertSame(
            [100, 100, 50],
            $this -> calculator -> calculatePayout(250)
        );
    }

}
