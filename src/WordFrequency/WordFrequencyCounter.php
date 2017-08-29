<?php
/*
 * Copyright 2017 Francesco Cocchianella. All rights reserved.
 *
 * This software is proprietary and may not be copied, distributed,
 * published or used in any way, in whole or in part, without prior
 * written agreement from the author.
 */

namespace WordFrequency;


class WordFrequencyCounter
{
    /**
     * @var WordsToArrayConverter
     */
    private $wordsToArrayConverter;

    /**
     * @var ArrayValuesCounter
     */
    private $arrayValuesCounter;

    /**
     * @var ArraySortValueDescendingKeyAscending
     */
    private $arraySortValueDescendingKeyAscending;

    /**
     * WordFrequencyCounter constructor.
     * @param WordsToArrayConverter $wordsToArrayConverter
     * @param ArrayValuesCounter $arrayValuesCounter
     * @param ArraySortValueDescendingKeyAscending $arraySortValueDescendingKeyAscending
     */
    public function __construct(
        WordsToArrayConverter $wordsToArrayConverter,
        ArrayValuesCounter $arrayValuesCounter,
        ArraySortValueDescendingKeyAscending $arraySortValueDescendingKeyAscending
    ) {
        $this->wordsToArrayConverter = $wordsToArrayConverter;
        $this->arrayValuesCounter = $arrayValuesCounter;
        $this->arraySortValueDescendingKeyAscending = $arraySortValueDescendingKeyAscending;
    }

    public function extractMostFrequentWords($text, $limit)
    {
        $wordsArray = $this->wordsToArrayConverter->convert($text);
        $valuesCount = $this->arrayValuesCounter->count($wordsArray);
        $sortedValues = $this->arraySortValueDescendingKeyAscending->sort($valuesCount);

        array_splice($sortedValues, $limit);

        return $sortedValues;
    }
}
