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
use WordFrequency\ArrayValuesCounter;
use WordFrequency\WordFrequencyCounter;
use WordFrequency\WordsToArrayConverter;

class WordFrequencyCounterTest extends TestCase
{
    public function testDisplayTwoMostFrequentWords()
    {
        $text = 'Red lorry, yellow lorry.';

        $expectedResult = ['lorry' => 2, 'red' => 1];

        $wordFrequencyCounter = new WordFrequencyCounter(
            new WordsToArrayConverter(),
            new ArrayValuesCounter(),
            new ArraySortValueDescendingKeyAscending()
        );

        Assert::assertSame($expectedResult, $wordFrequencyCounter->extractMostFrequentWords($text, 2));
    }
}
