<?php

declare(strict_types = 1);

namespace WithdrawalTest\Helpers;

use PHPUnit\Framework\TestCase;
use Withdrawal\Helpers\CashHelper;
use Withdrawal\Exceptions\NotEnoughNotesException;

class CashHelperTest extends TestCase
{
    public function testGetLowestNominalValueFirstValueIsAvailable ()
    {
        $helper = new CashHelper(
            [100, 50, 20, 10],
            [
            100 => 10,
            50 => 10,
            20 => 10,
            10 => 10
            ]
        );

        $this -> assertSame(
            10,
            $helper -> getLowestNominalValue()
        );
    }

    public function testGetLowestNominalValueFirstValueIsNotAvailable ()
    {
        $helper = new CashHelper(
            [100, 50, 20, 10],
            [
            100 => 10,
            50 => 10,
            20 => 10,
            10 => 0
            ]
        );

        $this -> assertSame(
            20,
            $helper -> getLowestNominalValue()
        );
    }

    public function testGetLowestNominalValueNoValueIsAvailable ()
    {
        $helper = new CashHelper(
            [100, 50, 20, 10],
            [
            100 => 0,
            50 => 0,
            20 => 0,
            10 => 0
            ]
        );

        $this -> expectException(NotEnoughNotesException::class);
        $helper -> getLowestNominalValue();
    }

    public function testGetFirstNominalValueFirstValueIsAvailable ()
    {
        $helper = new CashHelper(
            [100, 50, 20, 10],
            [
            100 => 10,
            50 => 10,
            20 => 10,
            10 => 10
            ]
        );

        $this -> assertSame(
            100,
            $helper -> getFirstNominalValue()
        );
    }

    public function testGetFirstNominalValueFirstValueIsNotAvailable ()
    {
        $helper = new CashHelper(
            [100, 50, 20, 10],
            [
            100 => 0,
            50 => 10,
            20 => 10,
            10 => 10
            ]
        );

        $this -> assertSame(
            50,
            $helper -> getFirstNominalValue()
        );
    }

    public function testGetFirstNominalValueNoValueIsAvailable ()
    {
        $helper = new CashHelper(
            [100, 50, 20, 10],
            [
            100 => 0,
            50 => 0,
            20 => 0,
            10 => 0
            ]
        );

        $this -> expectException(NotEnoughNotesException::class);
        $helper -> getFirstNominalValue();
    }

    public function testGetNextNominalValueFirstValueIsAvailable ()
    {
        $helper = new CashHelper(
            [100, 50, 20, 10],
            [
            100 => 10,
            50 => 10,
            20 => 10,
            10 => 10
            ]
        );

        $this -> assertSame(
            50,
            $helper -> getNextNominalValueDesc(100)
        );
    }

    public function testGetNextNominalValueFirstValueIsNotAvailable ()
    {
        $helper = new CashHelper(
            [100, 50, 20, 10],
            [
            100 => 10,
            50 => 0,
            20 => 10,
            10 => 10
            ]
        );

        $this -> assertSame(
            20,
            $helper -> getNextNominalValueDesc(100)
        );
    }

    public function testGetNextNominalValueNoValueIsAvailable ()
    {
        $helper = new CashHelper(
            [100, 50, 20, 10],
            [
            100 => 10,
            50 => 0,
            20 => 0,
            10 => 0
            ]
        );

        $this -> expectException(NotEnoughNotesException::class);
        $helper -> getNextNominalValueDesc(100);
    }

    public function testGetMaxAmount ()
    {
        $helper = new CashHelper(
            [100, 50, 20, 10],
            [
            100 => 2,
            50 => 3,
            20 => 1,
            10 => 1
            ]
        );

        $this -> assertSame(
            380,
            $helper -> getMaxAmount()
        );
    }

}
