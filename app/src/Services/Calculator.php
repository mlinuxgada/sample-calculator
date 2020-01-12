<?php

/**
 * Mihail Krastev <mlinuxgada@gmail.com>
 *
 * Calculator Service class
 */

namespace TechPods\SampleCalc\Services;

use TechPods\SampleCalc\Exceptions\UnsupportedOperationException;
use TechPods\SampleCalc\Exceptions\DataException;

/**
 * Calculator Service Class. Its functionality includes main process method
 * and a list with direct methods.
 * The real method is determined first if its in the list with allowed calc methods.
 * Then its called dynamically - we have an array, containig the association between operaion->method/function call.
 */
class Calculator
{

    /**
     * @var array operations
     */
    protected $operations = [
        'plus'           => 'plusOperation',
        'minus'          => 'minusOperation',
        'multiplication' => 'multiplicationOperation',
        'division'       => 'divisionOperation'
    ];

    /**
     * Main process method. Performs various simple checks - if operation/method allowed,
     * data number integrity, simple validation.
     * Then determining which method to call and pushes the numbers array to perform the needed
     * operation, and returns the result.
     *
     * @param string $operation
     * @param array $numbers
     * @throws UnsupportedOperationException\DataException
     *
     * @return \mixed
     */
    public function process($operation, $numbers)
    {
        if (!in_array($operation, array_keys($this->operations)))
        {
            throw new UnsupportedOperationException("Not supported operation");
        }

        if (count($numbers) < 2)
        {
            throw new DataException("Data for processing not valid");
        }

        foreach ($numbers as $element)
        {
            if (!is_numeric($element))
            {
                throw new DataException("Some of the numbers is not numeric representation");
            }
        }

        $method = $this->operations[$operation];

        return $this->$method($numbers);
    }


    /**
     * Performs additions operation - sums all elements from the numbers array
     *
     * @param array $numbers
     *
     * @return \mixed
     */
    public function plusOperation(array $numbers)
    {
        $res = array_shift($numbers);

        foreach ($numbers as $element)
        {
            $res += $element;
        }

        return $res;
    }

    /**
     * Performs substractions operation - substacts one by one element from the numbers array
     *
     * @param array $numbers
     *
     * @return \mixed
     */
    public function minusOperation(array $numbers)
    {
        $res = array_shift($numbers);

        foreach ($numbers as $element)
        {
            $res -= $element;
        }

        return $res;
    }

    /**
     * Performs multiplication operation - multiplies one by one element from the numbers array
     *
     * @param array $numbers
     *
     * @return \mixed
     */
    public function multiplicationOperation(array $numbers)
    {
        $res = array_shift($numbers);

        foreach ($numbers as $element)
        {
            $res *= $element;
        }

        return $res;
    }

    /**
     * Performs division operation - divisions all elements from the numbers array,
     * one by one, the order they are in the array
     *
     * @param array $numbers
     *
     * @return \mixed
     *
     * @throws UnsupportedOperationException
     */
    public function divisionOperation(array $numbers)
    {
        foreach ($numbers as $element)
        {
            if (0 == $element)
            {
                throw new UnsupportedOperationException("Division by 0 not supported");
            }
        }

        $res = array_shift($numbers);

        foreach ($numbers as $element)
        {
            $res /= $element;
        }

        return $res;
    }
}
