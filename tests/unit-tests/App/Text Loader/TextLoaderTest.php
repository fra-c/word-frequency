<?php
/*
 * Copyright 2017 Francesco Cocchianella. All rights reserved.
 *
 * This software is proprietary and may not be copied, distributed,
 * published or used in any way, in whole or in part, without prior
 * written agreement from the author.
 */

namespace Test\App\TextLoader;

use App\TextLoader\Exception\EmptyTextException;
use App\TextLoader\Exception\FileNotFoundException;
use App\TextLoader\TextLoader;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class TextLoaderTest extends TestCase
{
    /**
     * Tests loading text from a file.
     */
    public function testLoadFromFile()
    {
        $filePath = __DIR__ . '/test-file.txt';
        $expectedResult = 'test' . PHP_EOL;

        $textLoader = new TextLoader();

        Assert::assertSame($expectedResult, $textLoader->load($filePath));
    }

    /**
     * Tests a non-existent file. An exception should be thrown.
     */
    public function testNonExistingFileShouldThrowException()
    {
        $this->expectException(FileNotFoundException::class);

        $textLoader = new TextLoader();

        $textLoader->load('non-existing-file.txt');
    }

    /**
     * Tests an empty file. An exception should be thrown.
     */
    public function testEmptyFileShouldThrowException()
    {
        $this->expectException(EmptyTextException::class);

        $filePath = __DIR__ . '/empty-file.txt';

        $textLoader = new TextLoader();

        $textLoader->load($filePath);
    }
}
