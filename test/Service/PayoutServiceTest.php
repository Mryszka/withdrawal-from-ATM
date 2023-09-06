<?php
declare(strict_types = 1);

namespace WithdrawalTest\Service;

use PHPUnit\Framework\TestCase;
use Withdrawal\Services\PayoutService;
use Withdrawal\Validators\AmountValidator;
use Withdrawal\Validators\PayoutValidator;
use Withdrawal\Exceptions\NotEnoughNotesException;


class PayoutServiceTest extends TestCase
{
    protected PayoutService $service;
    
    public function setUp (): void
    {
        $this->service = new PayoutService(new AmountValidator(), new PayoutValidator());
    }

    public function testGetPayout() {

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
//        $this -> expectException(NotEnoughNotesException::class);
    }
    
}
