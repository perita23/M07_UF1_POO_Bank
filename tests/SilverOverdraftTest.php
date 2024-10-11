<?php
use ComBank\OverdraftStrategy\SilverOverdraft;
use PHPUnit\Framework\TestCase;

/**
 * Created by VS Code.
 * User: JPortugal
 * Date: 7/28/24
 * Time: 2:05 PM
 */

class SilverOverdraftTest extends TestCase
{

    /**
     * @test;
     * @dataProvider newAmountsProvider
     * */
    public function testOverdraft($newAmount,$expected){

        //Silver grant 100.00 overdraft funds.
        $overdraft = new SilverOverdraft();
        $this->assertEquals($expected,$overdraft->isGrantOverdraftFunds($newAmount));
    }

    /**
     * @return array;
     * */
    public function newAmountsProvider()
    {
        return [
            [50,true],
            [-50,true],
            [-100,true],
            [-101,false]
        ];
    }
}