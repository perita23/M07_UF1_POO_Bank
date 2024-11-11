<?php
namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 11:30 AM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use ComBank\Support\Traits\ApiTrait;
class DepositTransaction extends BaseTransaction implements BankTransactionInterface
{
    public function applyTransaction(BackAccountInterface $account): float
    {
        if ($this->detectFraud($this)) {
            $account->setBalance($account->getBalance() + $this->amount);
            return $account->getBalance();
        } else {
            throw new FailedTransactionException("Error Processing Request", 1);

        }

    }
    public function getTransactionInfo(): string
    {
        return 'DEPOSIT_TRANSACTION';
    }
    public function getAmount(): float
    {
        return $this->amount;
    }
}