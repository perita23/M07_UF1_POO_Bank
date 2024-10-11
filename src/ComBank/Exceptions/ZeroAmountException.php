<?php namespace ComBank\Exceptions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 11:38 AM
 */

class ZeroAmountException extends BaseExceptions
{
    protected $errorCode = 101;
    protected $errorLabel = 'ZeroAmountException';
}
