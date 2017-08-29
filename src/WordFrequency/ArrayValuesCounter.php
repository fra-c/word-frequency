<?php
/*
 * Copyright 2017 Francesco Cocchianella. All rights reserved.
 *
 * This software is proprietary and may not be copied, distributed,
 * published or used in any way, in whole or in part, without prior
 * written agreement from the author.
 */

namespace WordFrequency;

class ArrayValuesCounter
{
    /**
     * Counts the values in $array and return an associative array with the values as keys and the count as value.
     *
     * @param string[] $array
     *
     * @return array
     */
    public function count(array $array)
    {
        return array_count_values(
            array_map(
                function ($item) {
                    return strtolower($item);
                },
                $array
            )
        );
    }
}
