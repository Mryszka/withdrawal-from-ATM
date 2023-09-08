<?php

declare(strict_types = 1);

namespace WithdrawalTest\Validators;

use PHPUnit\Framework\TestCase;
use Withdrawal\Exceptions\InvalidArgumentException;
use Withdrawal\Exceptions\NotEnoughNotesException;
use Withdrawal\Exceptions\NoteUnavailableException;
use Withdrawal\Validators\AmountValidator;
use Withdrawal\Helpers\CashHelper;

class AmountValidatorTest extends TestCase
{

    protected AmountValidator $validator;
    protected MockObject | CashHelper $helper;

    public function setUp (): void
    {
        $this -> helper = $this -> createMock(CashHelper::class);
        $this -> validator = new AmountValidator($this -> helper);
    }

    /**
     * @dataProvider throwExceptionProvider
     */
    public function testCheckAmountThrowException (
        int $amount,
        string $exception
    )
    {
        $this -> helper -> method('getMaxAmount') -> willReturn(500);
        $this -> helper -> method('getLowestNominalValue') -> willReturn(10);
        $this -> expectException($exception);
        $this -> validator -> checkAmount($amount);
    }

    /**
     * @dataProvider notThrowExceptionProvider
     */
    public function testCheckAmountNotThrowException (
        int $amount
    )
    {
        $this -> helper -> method('getMaxAmount') -> willReturn(500);
        $this -> helper -> method('getLowestNominalValue') -> willReturn(10);
        $this -> expectNotToPerformAssertions();
        $this -> validator -> checkAmount($amount);
    }

    public static function throwExceptionProvider ()
    {
        yield [2000, NotEnoughNotesException::class];
        yield [-20, InvalidArgumentException::class];
        yield [123, NoteUnavailableException::class];
    }

    public static function notThrowExceptionProvider ()
    {
        yield [80];
        yield [500];
        yield [0];
    }

}
