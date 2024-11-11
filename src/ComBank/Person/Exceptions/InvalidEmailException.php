<?php
namespace ComBank\Person\Exceptions;
use ComBank\Exceptions\BaseExceptions;
/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 2:29 PM
 */

class InvalidEmailException extends BaseExceptions
{
    protected $errorCode = 500;
    protected $errorLabel = 'InvalidEmailException';
}