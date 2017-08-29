<?php
/*
 * Copyright 2017 Francesco Cocchianella. All rights reserved.
 *
 * This software is proprietary and may not be copied, distributed,
 * published or used in any way, in whole or in part, without prior
 * written agreement from the author.
 */

namespace WordFrequency;

class ArraySortValueDescendingKeyAscending
{
    /**
     * Sort an array by value descending and by key descending
     *
     * @param array $array
     *
     * @return array
     */
    public function sort(array $array)
    {
        array_multisort(
            array_values($array),
            SORT_DESC,
            array_keys($array),
            SORT_ASC,
            $array
        );

        return $array;
    }
}
