<?php

declare(strict_types = 1);

namespace WithdrawalTest\Validators;

use PHPUnit\Framework\TestCase;
use Withdrawal\Exceptions\InvalidArgumentException;
use Withdrawal\Exceptions\NotEnoughNotesException;
use Withdrawal\Exceptions\NoteUnavailableException;
use Withdrawal\Validators\AmountValidator;

class AmountValidatorTest extends TestCase
{

    protected AmountValidator $validator;

    public function setUp (): void
    {
        $this -> validator = new AmountValidator();
    }

    /**
     * @dataProvider throwExceptionProvider
     */
    public function testCheckAmountThrowException (
        int $amount,
        int $maxNumberOfBankNotes,
        int $highestNominalValue,
        int $lowestNominalValue,
        string $exception
    )
    {
        $this -> expectException($exception);
        $this -> validator -> checkAmount($amount, $maxNumberOfBankNotes, $highestNominalValue, $lowestNominalValue);
    }

    /**
     * @dataProvider notThrowExceptionProvider
     */
    public function testCheckAmountNotThrowException (
        int $amount,
        int $maxNumberOfBankNotes,
        int $highestNominalValue,
        int $lowestNominalValue
    )
    {
        $this -> expectNotToPerformAssertions();
        $this -> validator -> checkAmount($amount, $maxNumberOfBankNotes, $highestNominalValue, $lowestNominalValue);
    }

    public static function throwExceptionProvider ()
    {
        yield [2000, 2, 100, 10, NotEnoughNotesException::class];
        yield [-20, 2, 100, 10, InvalidArgumentException::class];
        yield [123, 2, 100, 10, NoteUnavailableException::class];
    }

    public static function notThrowExceptionProvider ()
    {
        yield [100, 2, 100, 10];
        yield [100, 2, 50, 10];
        yield [80, 10, 100, 10];
    }

}
