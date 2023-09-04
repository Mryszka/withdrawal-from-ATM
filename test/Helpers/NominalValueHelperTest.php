<?php

declare(strict_types = 1);

namespace WithdrawalTest\Helpers;

use PHPUnit\Framework\TestCase;
use Withdrawal\Helpers\NominalValueHelper;

class NominalValueHelperTest extends TestCase
{

    /**
     * @dataProvider bankNotesHigestHelperProvider
     */
    public function testGetHighestNominalValue (array $availableBankNotes, int $expectedResult)
    {
        $helper = new NominalValueHelper($availableBankNotes);
        $this -> assertSame(
            $expectedResult,
            $helper -> getHighestNominalValue()
        );
    }

    /**
     * @dataProvider bankNotesLowestHelperProvider
     */
    public function testGetLowestNominalValue (array $availableBankNotes, int $expectedResult)
    {
        $helper = new NominalValueHelper($availableBankNotes);
        $this -> assertSame(
            $expectedResult,
            $helper -> getLowestNominalValue()
        );
    }

    public static function bankNotesHigestHelperProvider ()
    {
        yield [[100, 30, 50], 100];
        yield [[20], 20];
        yield [[50, 10, 100, 20], 100];
    }

    public static function bankNotesLowestHelperProvider ()
    {
        yield [[100, 30, 50], 30];
        yield [[20], 20];
        yield [[50, 10, 100, 20], 10];
    }

}
