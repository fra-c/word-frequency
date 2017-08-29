<?php
/*
 * Copyright 2017 Francesco Cocchianella. All rights reserved.
 *
 * This software is proprietary and may not be copied, distributed,
 * published or used in any way, in whole or in part, without prior
 * written agreement from the author.
 */

namespace App\TextLoader;

use App\TextLoader\Exception\EmptyTextException;
use App\TextLoader\Exception\FileNotFoundException;

class TextLoader
{
    /**
     * Loads text from file or URL and return its contents
     *
     * @param string $source
     *
     * @return bool|string
     *
     * @throws EmptyTextException
     * @throws FileNotFoundException
     * @throws TextLoadingException
     */
    public function load($source)
    {
        if (!$this->isUrl($source)) {
            $this->assertFileExists($source);
        }

        $text = file_get_contents($source);

        if (empty($text)) {
            throw new EmptyTextException(sprintf('Source "%s" is empty.', $source));
        }

        return $text;
    }

    /**
     * Detects if $source is a URL.
     *
     * @param string $source
     *
     * @return bool
     */
    private function isUrl($source)
    {
        return strpos($source, 'http') === 0;
    }

    /**
     * @param $filePath
     *
     * @throws FileNotFoundException
     */
    private function assertFileExists($filePath)
    {
        if (!file_exists($filePath)) {
            throw new FileNotFoundException(sprintf('File "%s" not found.', $filePath));
        }
    }
}
