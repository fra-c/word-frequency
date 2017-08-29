<?php
/*
 * Copyright 2017 Francesco Cocchianella. All rights reserved.
 *
 * This software is proprietary and may not be copied, distributed,
 * published or used in any way, in whole or in part, without prior
 * written agreement from the author.
 */

namespace WordFrequency;

class WordsToArrayConverter
{
    const REGEXP_ANY_NON_WORD = '/\W+/';

    /**
     * Return all the words found in $text as an array.
     *
     * @param string $text The text from which the words will be extracted.
     *
     * @return string[]
     */
    public function convert($text)
    {
        return array_filter(
            preg_split(static::REGEXP_ANY_NON_WORD, $text)
        );
    }
}
