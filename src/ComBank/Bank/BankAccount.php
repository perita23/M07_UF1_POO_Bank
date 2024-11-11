<?php

namespace ComBank\Bank;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:25 PM
 */

use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\OverdraftStrategy\Contracts\OverdraftInterface;
use ComBank\Support\Traits\AmountValidationTrait;
use ComBank\Support\Traits\ApiTrait;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use ComBank\Transactions\DepositTransaction;
use ComBank\Person\Person;

use function PHPUnit\Framework\equalTo;
use function PHPUnit\Framework\throwException;

class BankAccount implements BackAccountInterface
{
    use ApiTrait;
    protected Person $PersonHolder;
    protected float $balance;
    protected $status;
    protected OverdraftInterface $overdraft;
    protected $currency;

    /***** Implemented functions *******/
    public function transaction(BankTransactionInterface $transaction): void
    {
        if ($this->status != BackAccountInterface::STATUS_CLOSED) {
            $transaction->applyTransaction($this);
        } else {
            throw new BankAccountException("Error Processing Request", 1);
        }
    }
    public function
        openAccount(
    ): bool {
        if ($this->status == BackAccountInterface::STATUS_OPEN) {
            return true;
        } else {
            return false;
        }
    }
    public function reopenAccount(): void
    {
        if ($this->status == BackAccountInterface::STATUS_CLOSED) {
            $this->status = BackAccountInterface::STATUS_OPEN;
            echo "My account is now reopened<br>";
        } else {
            throw new BankAccountException("Account is alredy open", 1);
        }
    }
    public function closeAccount(): void
    {
        if ($this->status == BackAccountInterface::STATUS_OPEN) {
            $this->status = BackAccountInterface::STATUS_CLOSED;
            echo "My account is now closed<br><br>";
        } else {
            throw new BankAccountException("Account is already closed<br>", 1);
        }
    }
    public function getBalance(): float
    {
        return $this->balance;
    }
    public function getOverdraft(): OverdraftInterface
    {
        return $this->overdraft;
    }
    public function applyOverdraft(OverdraftInterface $overdraft): void
    {
        $this->overdraft = $overdraft;
    }
    public function setBalance(float $amount): void
    {
        $this->balance = $amount;
    }

    public function getPersonHolder()
    {
        return $this->PersonHolder;
    }

    public function setPersonHolder($PersonHolder)
    {
        $this->PersonHolder = $PersonHolder;
        return $this;
    }
    public function __construct($balance = null, $currency = "€")
    {
        $this->balance = $balance;
        $this->status = BackAccountInterface::STATUS_OPEN;
        $this->overdraft = new NoOverdraft();
        $this->currency = $currency;
    }


}