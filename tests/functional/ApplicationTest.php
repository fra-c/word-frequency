<?php
/*
 * Copyright 2017 Francesco Cocchianella. All rights reserved.
 *
 * This software is proprietary and may not be copied, distributed,
 * published or used in any way, in whole or in part, without prior
 * written agreement from the author.
 */

namespace Test;

use App\Application;
use App\Command\WordFrequencyCommand;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ApplicationTest extends TestCase
{
    /**
     * @var CommandTester
     */
    protected $commandTester;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $application = new Application();

        $application->add(new WordFrequencyCommand());

        $command = $application->find('word-frequency');

        $this->commandTester = new CommandTester($command);
    }

    /**
     * Tests a non-existing file. An error message should be displayed.
     */
    public function testWordFrequencyCounterFileNotFound()
    {
        $filePath = 'non-existing-file.txt';
        $expectedOutput = sprintf('File "%s" not found.', $filePath) . PHP_EOL;

        $this->commandTester->execute([
            'source' => $filePath
        ]);

        $output = $this->commandTester->getDisplay();

        Assert::assertSame($expectedOutput, $output);
    }

    /**
     * Tests an empty text file. An error message should be displayed.
     */
    public function testWordFrequencyCounterEmptyFile()
    {
        $filePath = __DIR__.'/fixtures/empty-file.txt';
        $expectedOutput = sprintf('"%s" is an empty file.', $filePath) . PHP_EOL;

        $this->commandTester->execute([
            'source' => $filePath
        ]);

        $output = $this->commandTester->getDisplay();

        Assert::assertSame($expectedOutput, $output);
    }

    /**
     * Tests a file containing text. A list of words along with their frequency should be displayed.
     */
    public function testWordFrequencyCounterFileWithWords()
    {
        $this->commandTester->execute([
            'source' => __DIR__.'/fixtures/file-with-words.txt'
        ]);

        $output = $this->commandTester->getDisplay();

        $expectedOutput = <<<EOF
sells,4
she,4
seashore,3
shells,3
the,3
seashells,2
are,1
by,1
i,1
if,1
m,1
on,1
so,1
sure,1
surely,1

EOF;

        Assert::assertSame($expectedOutput, $output);
    }

    /**
     * Tests the default limit of words to display.
     */
    public function testWordFrequencyCounterDefaultLimit()
    {
        $this->commandTester->execute([
            'source' => __DIR__.'/fixtures/file-with-107-unique-words.txt'
        ]);

        $output = trim($this->commandTester->getDisplay());

        Assert::assertCount(WordFrequencyCommand::WORDS_LIMIT_DEFAULT, explode(PHP_EOL, $output));
    }

    /**
     * Tests the "limit" option. When passed to the command the output should be limited to this value.
     */
    public function testWordFrequencyCounterWithLimit()
    {
        $this->commandTester->execute([
            'source' => __DIR__.'/fixtures/file-with-words.txt',
            '--limit' => 3
        ]);

        $output = $this->commandTester->getDisplay();

        $expectedOutput = <<<EOF
sells,4
she,4
seashore,3

EOF;

        Assert::assertSame($expectedOutput, $output);
    }

    /**
     * Tests a file with no words. An error message should be displayed
     */
    public function testWordFrequencyCounterFileWithNoWords()
    {
        $filePath = __DIR__.'/fixtures/file-with-no-words.txt';
        $expectedOutput = sprintf('No words found in "%s".', $filePath) . PHP_EOL;

        $this->commandTester->execute([
            'source' => $filePath
        ]);

        $output = $this->commandTester->getDisplay();

        Assert::assertSame($expectedOutput, $output);
    }
}
