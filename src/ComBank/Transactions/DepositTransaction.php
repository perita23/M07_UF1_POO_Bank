<?php namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 11:30 AM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Transactions\Contracts\BankTransactionInterface;

class DepositTransaction extends BaseTransaction implements BankTransactionInterface
{

    public function __construct(float $amount) {
        $this->validateAmount($amount);
        $this->amount = $amount;
    }
    public function applyTransaction(BackAccountInterface $account): float{
        $account->setBalance($account->getBalance() + $this->amount);
        return $account->getBalance();
    }
    public function getTransactionInfo(): string{
        return 'DEPOSIT_TRANSACTION';
    }
    public function getAmount(): float{
        return $this->amount;
    }
}
