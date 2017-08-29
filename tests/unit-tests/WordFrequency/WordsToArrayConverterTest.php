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
use WordFrequency\WordsToArrayConverter;

class WordsToArrayConverterTest extends TestCase
{
    public function testWordsToArrayConversion()
    {
        $text = 'one, two three.. Example! ?';

        $wordsToArrayConverter = new WordsToArrayConverter();

        Assert::assertEquals(['one', 'two', 'three', 'Example'], $wordsToArrayConverter->convert($text));
    }
}
