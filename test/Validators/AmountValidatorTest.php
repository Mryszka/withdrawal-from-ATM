<?php

declare(strict_types=1);

namespace WithdrawalTest\Validators;

use PHPUnit\Framework\TestCase;
use Withdrawal\Exceptions\InvalidArgumentException;
use Withdrawal\Exceptions\NotEnoughNotesException;
use Withdrawal\Exceptions\NoteUnavailableException;
use Withdrawal\Validators\AmountValidator;

class AmountValidatorTest extends TestCase {

    protected AmountValidator $validator;

    public function setUp(): void {
        $this->validator = new AmountValidator();
    }

    /**
     * @dataProvider throwExceptionProvider
     */
    public function testCheckAmountThrowException(
            int $sum,
            int $maxNumberOfBanknotes,
            int $highestDenomination,
            int $lowestDenomination,
            string $exception
    ) {
        $this->expectException($exception);
        $this->validator->checkAmount($sum, $maxNumberOfBanknotes, $highestDenomination, $lowestDenomination);
    }

    /**
     * @dataProvider notThrowExceptionProvider
     */
    public function testCheckAmountNotThrowException(
            int $sum,
            int $maxNumberOfBanknotes,
            int $highestDenomination,
            int $lowestDenomination
    ) {
        $this->expectNotToPerformAssertions();
        $this->validator->checkAmount($sum, $maxNumberOfBanknotes, $highestDenomination, $lowestDenomination);
    }

    public static function throwExceptionProvider() {
        yield [2000, 2, 100, 10, NotEnoughNotesException::class];
        yield [-20, 2, 100, 10, InvalidArgumentException::class];
        yield [123, 2, 100, 10, NoteUnavailableException::class];
    }

    public static function notThrowExceptionProvider() {
        yield [100, 2, 100, 10];
        yield [100, 2, 50, 10];
        yield [80, 10, 100, 10];
    }

}
