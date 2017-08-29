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
use WordFrequency\ArraySortValueDescendingKeyAscending;

class ArraySortValueDescendingKeyAscendingTest extends TestCase
{
    /**
     * Tests sorting an array by value descending and by key ascending when value is equal.
     */
    public function testSorting()
    {
        $array = [
            'f' => 3,
            'a' => 3,
            'c' => 3,
            'g' => 2,
            'b' => 3,
            'e' => 2,
            'd' => 2
        ];

        $expectedResult = [
            'a' => 3,
            'b' => 3,
            'c' => 3,
            'f' => 3,
            'd' => 2,
            'e' => 2,
            'g' => 2,
        ];

        $arraySort = new ArraySortValueDescendingKeyAscending();

        Assert::assertSame($expectedResult, $arraySort->sort($array));
    }
}
