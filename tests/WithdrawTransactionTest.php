<?php
use PHPUnit\Framework\TestCase;
use ComBank\Bank\BankAccount;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use ComBank\OverdraftStrategy\SilverOverdraft;
use ComBank\Exceptions\BankAccountException;
use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Transactions\WithdrawTransaction;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Exceptions\ZeroAmountException;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:47 PM
 */

class WithdrawTransactionTest extends TestCase
{

    /**
     * @test
     * */
    public function testWithdrawTransactionMoreThanBalance()
    {     

        $bankAccount = new BankAccount(150.0);
        $amount = 50;
        $trans = new WithdrawTransaction($amount);
        $newBalance = $trans->applyTransaction($bankAccount);
        $this->assertEquals(100,$newBalance);
    }
    /**
     * @test
     * @expectedException ComBank\Exceptions\InvalidOverdraftFundsException
     * */
    public function testWithdrawTransactionLessThanBalanceNoOverdraft()
    {
        $this->expectException(InvalidOverdraftFundsException::class);

        $bankAccount = new BankAccount(100.0);

        $amount = 150;
        $trans = new WithdrawTransaction($amount);
        $newBalance = $trans->applyTransaction($bankAccount);
        $this->assertEquals(100,$newBalance);
    }
    /**
     * @test
     * */
    public function testWithdrawTransactionLessThanBalanceWithOverdraft()
    {
        $bankAccount = new BankAccount(100.0);
        $bankAccount->applyOverdraft(new SilverOverdraft());

        $amount = 150;
        $trans = new WithdrawTransaction($amount);
        $newBalance = $trans->applyTransaction($bankAccount);
        $this->assertEquals(-50,$newBalance);
    }
    /**
     * @test
     * @dataProvider invalidAmountProvider
     * @expectedException ComBank\Exceptions\InvalidArgsException
     * */
    public function testInvalidAmount($amount)
    {
        $this->expectException(ZeroAmountException::class);
        new WithdrawTransaction($amount);
    }
    
    /**
     * @test
     * */
    public function testTransactionInfo()
    {
        $trans = new WithdrawTransaction(22.0);
        $this->assertEquals('WITHDRAW_TRANSACTION',$trans->getTransactionInfo());
    }
    /**
     * @test
     * */
    public function testGetAmount(){
        $trans = new WithdrawTransaction(100.25);
        $this->assertEquals(100.25,$trans->getAmount());
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