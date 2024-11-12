<?php
namespace ComBank\Bank;
use ComBank\Bank\BankAccount;
use ComBank\Bank\Contracts\BackAccountInterface;
use ComBank\Exceptions\BankAccountException;
use ComBank\OverdraftStrategy\NoOverdraft;
use ComBank\OverdraftStrategy\SilverOverdraft;

class InternationalBankAccount extends BankAccount
{
    function getConvertedBalance(): float
    {
        $convBalance = $this->convertBalance($this->getBalance());
        return $this->getBalance() * $convBalance;
    }
    function getConvertedCurrency(): string
    {
        return "USD";
    }



}