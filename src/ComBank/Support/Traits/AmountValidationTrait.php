<?php namespace ComBank\Support\Traits;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 2:35 PM
 */

use ComBank\Exceptions\InvalidArgsException;
use ComBank\Exceptions\ZeroAmountException;

use function PHPUnit\Framework\isNan;

trait AmountValidationTrait
{
    /**
     * @param float $amount
     * @throws InvalidArgsException
     * @throws ZeroAmountException
     */
    public function validateAmount(float $amount):void
    {
        if ($amount <= 0){
            throw new ZeroAmountException("Error Processing Request", 1);
        }
        if (is_nan($amount)){
            throw new InvalidArgsException("Error Processing Request", 1);
        }
    }
}
