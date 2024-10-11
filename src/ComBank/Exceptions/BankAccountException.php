<?php namespace ComBank\Exceptions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 2:29 PM
 */

class BankAccountException extends BaseExceptions
{
    protected $errorCode = 500;
    protected $errorLabel = 'BankAccountException';
}
