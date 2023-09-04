<?php

declare(strict_types = 1);

namespace WithdrawalTest\Validators;

use PHPUnit\Framework\TestCase;
use Withdrawal\Exceptions\NotEnoughNotesException;
use Withdrawal\Validators\PayoutValidator;

class PayoutValidatorTest extends TestCase
{

    protected PayoutValidator $validator;

    public function setUp (): void
    {
        $this -> validator = new PayoutValidator();
    }

    /**
     * @dataProvider throwExceptionProvider
     */
    public function testCheckAmountThrowException (int $maxNumberOfBanknotes, array $payout)
    {
        $this -> expectException(NotEnoughNotesException::class);
        $this -> validator -> checkPayout($maxNumberOfBanknotes, $payout);
    }

    /**
     * @dataProvider notThrowExceptionProvider
     */
    public function testCheckAmountNotThrowException (int $maxNumberOfBanknotes, array $payout)
    {
        $this -> expectNotToPerformAssertions();
        $this -> validator -> checkPayout($maxNumberOfBanknotes, $payout);
    }

    public static function throwExceptionProvider ()
    {
        yield [2, [100, 100, 50]];
        yield [4, [100, 100, 50, 20, 10]];
    }

    public static function notThrowExceptionProvider ()
    {
        yield [7, [100, 100, 50]];
        yield [5, [100, 100, 50, 20, 10]];
    }

}
