<?php

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/27/24
 * Time: 7:24 PM
 */
require_once 'bootstrap.php';
use ComBank\Bank\BankAccount;
use ComBank\OverdraftStrategy\SilverOverdraft;
use ComBank\Transactions\DepositTransaction;
use ComBank\Transactions\WithdrawTransaction;
use ComBank\Exceptions\BankAccountException;
use ComBank\Exceptions\FailedTransactionException;
use ComBank\Exceptions\InvalidOverdraftFundsException;
use ComBank\Exceptions\ZeroAmountException;
use PHPUnit\Runner\InvalidOrderException;
use ComBank\Person\Exceptions\InvalidEmailException;
use ComBank\Person\Person;
use ComBank\Bank\InternationalBankAccount;
use ComBank\Bank\NationalBankAccount;




//---[Bank account 1]---/
// create a new account1 with balance 400
echo "<b>Creando bank account con un personHolder</b><br><br>";
echo "Persona con email valido:<br>";
try {
    $person = new Person("hugo", 2323, "hugobedmar@gmail.com");
    echo "Email: " . $person->getEmail() . "<br>";
    echo "Email validation => Email Valido<br><br>";
} catch (InvalidEmailException $e) {
    echo "El email no es valido<br><br>";
}
echo "Persona con email invalido<br>";
try {
    $person2 = new Person("hugo", 2323, "hugobedmar@example.com");
    echo "Email: hugobedmar@example.com<br>";

} catch (InvalidEmailException $e) {
    echo "El email no es valido<br><br>";
}

$internationalBank = new InternationalBankAccount(400, "€");
$internationalBank->setPersonHolder($person);
echo "My Balance: " . $internationalBank->getBalance() . "<br><br>";
echo "My converted balance: " . $internationalBank->getConvertedBalance() . "<br><br>";

$bankAccount1 = new BankAccount(400);
echo "<hr>";
pl('--------- [Start testing bank account #1, noOverdraft (400.0 funds)] --------');
try {
    // show balance account
    echo "My Balance:" . $bankAccount1->getBalance() . "<br><br>";
    // close account
    $bankAccount1->closeAccount();
    // reopen account
    $bankAccount1->reopenAccount();
    // deposit +150 
    pl('Doing transaction deposit (+150) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new DepositTransaction(150));
    pl('My new balance after deposit (+150) : ' . $bankAccount1->getBalance());

    // withdrawal -25
    pl('Doing transaction withdrawal (-25) with current balance ' . $bankAccount1->getBalance());
    $bankAccount1->transaction(new WithdrawTransaction(25));
    pl('My new balance after withdrawal (-25) : ' . $bankAccount1->getBalance());

    // withdrawal -600
    try {
        pl('Doing transaction withdrawal (-600) with current balance ' . $bankAccount1->getBalance());
        $bankAccount1->transaction(new WithdrawTransaction(600));
    } catch (InvalidOverdraftFundsException $e) {
        pl($e->getMessage());
    }


} catch (ZeroAmountException $e) {
    pl($e->getMessage());
} catch (BankAccountException $e) {
    pl($e->getMessage());
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My balance after failed last transaction : ' . $bankAccount1->getBalance());


//---[Bank account 2]---/
$bankAccount2 = new BankAccount(200);
$bankAccount2->applyOverdraft(new SilverOverdraft());
pl('--------- [Start testing bank account #2, Silver overdraft (100.0 funds)] --------');
try {

    // show balance account
    echo "My balance: " . $bankAccount2->getBalance() . "<br>";
    // deposit +100
    pl('Doing transaction deposit (+100) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new DepositTransaction(100));
    pl('My new balance after deposit (+100) : ' . $bankAccount2->getBalance());

    // withdrawal -300
    pl('Doing transaction deposit (-300) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(300));
    pl('My new balance after withdrawal (-300) : ' . $bankAccount2->getBalance());

    // withdrawal -50
    pl('Doing transaction deposit (-50) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(50));
    pl('My new balance after withdrawal (-50) with funds : ' . $bankAccount2->getBalance());

    // withdrawal -120
    pl('Doing transaction withdrawal (-120) with current balance ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(120));
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My balance after failed last transaction : ' . $bankAccount2->getBalance());

try {
    pl('Doing transaction withdrawal (-20) with current balance : ' . $bankAccount2->getBalance());
    $bankAccount2->transaction(new WithdrawTransaction(20));
} catch (FailedTransactionException $e) {
    pl('Error transaction: ' . $e->getMessage());
}
pl('My new balance after withdrawal (-20) with funds : ' . $bankAccount2->getBalance() . "<br>");
$bankAccount2->closeAccount();
try {
    $bankAccount2->closeAccount();
} catch (BankAccountException $e) {
    pl($e->getMessage());
}