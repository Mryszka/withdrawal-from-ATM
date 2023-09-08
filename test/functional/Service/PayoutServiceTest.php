<?php
declare(strict_types = 1);

namespace WithdrawalFTest\Service;

use PHPUnit\Framework\TestCase;
use Withdrawal\Services\PayoutService;
use Withdrawal\Exceptions\NotEnoughNotesException;
use Withdrawal\Exceptions\InvalidArgumentException;
use Withdrawal\Exceptions\NoteUnavailableException;


class PayoutServiceTest extends TestCase
{
    protected PayoutService $service;
    
    public function setUp (): void
    {
        $this->service = new PayoutService();
    }

    public function testGetPayoutTooMatchAmount() {

        $this -> expectException(NotEnoughNotesException::class);
        $this->service-> getPayout(2000);
    }
    
    public function testGetPayoutNegativAmount() {

        $this -> expectException(InvalidArgumentException::class);
        $this->service-> getPayout(-2000);
    }
    
    public function testGetPayoutBadNoteInAmount() {

        $this -> expectException(NoteUnavailableException::class);
        $this->service-> getPayout(225);
    }
    
    public function testGetPayoutSecondPayOutIsTooBig() {

        $this->assertSame(
                [100,100,100,100,100,100,100,100,100,100],
                $this->service-> getPayout(1000)
        );
        $this->assertSame(
                [50,50,50,50,50,50,50,50,50,50],
                $this->service-> getPayout(500)
        );
        $this -> expectException(NotEnoughNotesException::class);
        $this->service-> getPayout(900);
    }
    
}
