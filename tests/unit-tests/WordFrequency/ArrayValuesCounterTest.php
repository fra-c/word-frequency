<?php
/*
 * Copyright 2017 Francesco Cocchianella. All rights reserved.
 *
 * This software is proprietary and may not be copied, distributed,
 * published or used in any way, in whole or in part, without prior
 * written agreement from the author.
 */

namespace Test\WordFrequency;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use WordFrequency\ArrayValuesCounter;

class ArrayValuesCounterTest extends TestCase
{
    public function testArrayValuesCount()
    {
        $array = ['one', 'two', 'Two', 'three', 'Three', 'THREE'];

        $arrayValuesCounter = new ArrayValuesCounter();

        $expectedResult = [
            'one' => 1,
            'two' => 2,
            'three' => 3
        ];

        Assert::assertEquals($expectedResult, $arrayValuesCounter->count($array));
    }
}
