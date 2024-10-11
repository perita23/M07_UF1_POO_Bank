<?php namespace ComBank\Exceptions;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 11:34 AM
 */

class InvalidArgsException extends BaseExceptions
{
    protected $errorCode = 100;
    protected $errorLabel = 'InvalidArgsException';
}
