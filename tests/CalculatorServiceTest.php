<?php

use PHPUnit\Framework\TestCase;

use TechPods\SampleCalc\Services\Calculator; 

use TechPods\SampleCalc\Exceptions\UnsupportedOperationException;
use TechPods\SampleCalc\Exceptions\DataException;

/**
 * Calculator Service Test class - its main func/purpose is to
 * provice UT test coverage for the calc service. Includes basic func:
 *  - ensure proper methods called, if unsupported/unallowed method/op called
 *      proper UnsupportedOperationException ex MUST BE thrown
 *  - ensure data integrity - numbers should be numbers ONLY, if smth else is
 *      passed, eg non numerical elements, proper DataException MUST BE thrown
 *  - test plus, minus, multiplication, division ops
 *
 *  - test for division, specific when deividing by zero - not supported, not allowed,
 *      proper UnsupportedOperationException ex MUST BE thrown
 *
 */
final class CalculatorServiceTest extends TestCase
{

    /**
     * Test Calc service can be instantiated correctly, and from
     * proper class.
     *
     */
    public function testCreateCalculatorService(): void
    {
        $this->assertInstanceOf(
            Calculator::class,
            new Calculator()
        );
    }


    /**
     * Test Calc service operations - if an op is not allowed OR fake/whatever,
     * expect UnsupportedOperationException ex to be thrown.
     *
     */
    public function testOperations()
    {
        $allowedOperations = [
            'plus',
            'minus',
            'multiplication',
            'division'
        ];

        $operations = array_merge($allowedOperations, ['someFakeMethodA', 'someFakeMethodB']);

        $numbers = [2, 3];

        foreach ($operations as $operation)
        {
            if (!in_array($operation, $allowedOperations))
            {
                $this->expectException(UnsupportedOperationException::class);
            }

            $calcService = new Calculator();

            $res = $calcService->process($operation, $numbers);
        }

    }

    /**
     * Test Calc Service for invalid/non numberical data provided, for any operaion.
     * Expected/ensure proper DataException ex is thrown.
     *
     */
    public function testInvalidNumbers()
    {
        $this->expectException(DataException::class);
        $operation = 'plus';
        $numbers = [2, '1ab'];

        $calc = new Calculator();
        $calc->process($operation, $numbers);
    } 

    /**
     * Test Calc service plus operation
     *
     */
    public function testCalcServicePlusOperation()
    {
        $operation = 'plus';
        $numbers = [2, 3];

        $calc = new Calculator();

        $this->assertEquals(5, $calc->process($operation, $numbers));
    }

    /**
     * Test Calc service minus operation
     *
     */
    public function testCalcServiceMinusOperation()
    {
        $operation = 'minus';
        $numbers = [2, 3];

        $calc = new Calculator();

        $this->assertEquals(-1, $calc->process($operation, $numbers));
    }

    /**
     * Test Calc service multiplication operation
     *
     */
    public function testCalcServiceMultiplicationOperation()
    {
        $operation = 'multiplication';
        $numbers = [2, 3];

        $calc = new Calculator();

        $this->assertEquals(6, $calc->process($operation, $numbers));
    }

    /**
     * Test Calc service division operation
     *
     */
    public function testCalcServiceDivisionOperation()
    {
        $operation = 'division';
        $numbers = [5, 2];

        $calc = new Calculator();

        $this->assertEquals(2.5, $calc->process($operation, $numbers));
    }

    /**
     * Test Calc service division operation - dividing by zero is not supported,
     * should throw UnsupportedOperationException ex.
     *
     */
    public function testCalcServiceDivisionByZeroOperation()
    {
        $this->expectException(UnsupportedOperationException::class);
        $operation = 'division';
        $numbers = [5, 0];

        $calc = new Calculator();
        $calc->process($operation, $numbers);
    }
}
