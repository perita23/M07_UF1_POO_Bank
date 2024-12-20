<?php

namespace ComBank\Transactions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 1:22 PM
 */

use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use \ComBank\Support\Traits\ApiTrait;

class WithdrawTransaction extends BaseTransaction implements BankTransactionInterface
{

    public function applyTransaction(BackAccountInterface $account): float
    {
        $response = $this->detectFraud($this);
        if (!$response["action"]) {
            if ($account->getOverdraft()->isGrantOverdraftFunds($account->getBalance() - $this->amount)) {
                $account->setBalance($account->getBalance() - $this->amount);
                return $account->getBalance();
            }
            if ($account->getOverdraft()->getOverdraftFundsAmount() == 0) {
                throw new InvalidOverdraftFundsException("Withdrawal exceeds overdraft limit.", 1);
            }
        } else {
            throw new FailedTransactionException("<b>Failed withdraw transaction</b>: Risk = " . $response["risk"] . "", 1);
        }
        throw new FailedTransactionException("insufficient balance to complete the withdrawal", 1);
    }
    public function getTransactionInfo(): string
    {
        return 'WITHDRAW_TRANSACTION';
    }
    public function getAmount(): float
    {
        return $this->amount;
    }
}