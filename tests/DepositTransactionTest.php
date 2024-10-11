<?php

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 11:41 AM
 */

use ComBank\Bank\BankAccount;
use PHPUnit\Framework\TestCase;
use ComBank\Transactions\DepositTransaction;
use ComBank\Exceptions\ZeroAmountException;

class DepositTransactionTest extends TestCase
{

    /**
     * @test
     * */
    public function testApplyTransaction()
    {
        $bankAccount =  new BankAccount(50.25);
        $amount = 25.25;
        $trans = new DepositTransaction($amount);
        $newBalance = $trans->applyTransaction($bankAccount);
        $this->assertEquals(75.50, $newBalance);
    }
    /**
     * @test
     * @dataProvider invalidAmountProvider
     * @expectedException ComBank\Exceptions\ZeroAmountException
     * */
    public function testInvalidAmount($amount)
    {
        $this->expectException(ZeroAmountException::class);
        new DepositTransaction($amount);
    }
    
    /**
     * @test
     * */
    public function testTransactionInfo()
    {
        $trans = new DepositTransaction(22.0);
        $this->assertEquals('DEPOSIT_TRANSACTION', $trans->getTransactionInfo());
    }
    /**
     * @test
     * */
    public function testGetAmount()
    {
        $trans = new DepositTransaction(100.25);
        $this->assertEquals(100.25, $trans->getAmount());
    }
    /**
     * @return array;
     * */
    public function invalidAmountProvider()
    {
        return [
            [-100],   // Negative value
            [-0.01],  // Small negative value
            [0]       // Zero amount
        ];
    }    
}
