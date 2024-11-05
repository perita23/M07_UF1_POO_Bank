<?php
namespace ComBank\Support\Traits;

use ComBank\Transactions\Contracts\BankTransactionInterface;

trait ApiTrait
{
    function validateEmail(string $email): bool
    {
        return true;
    }
    function convertBalance(float $amount): float
    {
        return 0.0;
    }

    function detectFraud(BankTransactionInterface $interface): bool
    {
        return true;
    }
}