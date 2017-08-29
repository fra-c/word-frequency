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
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

class ApplicationTest extends TestCase
{
    /**
     * @var CommandTester
     */
    protected $commandTester;

    public function setUp()
    {
        $application = new Application();

        $application->add(new WordFrequencyCommand());

        $command = $application->find('word-frequency');

        $this->commandTester = new CommandTester($command);
    }

    public function testWordFrequencyCounterFileNotFound()
    {
        $this->commandTester->execute([
            'source' => 'non-existing-file.txt'
        ]);

        $output = $this->commandTester->getDisplay();
        Assert::assertContains('File not found', $output);
    }

    public function testWordFrequencyCounterFileWithNoWords()
    {
        $this->commandTester->execute([
            'source' => __DIR__.'/fixtures/file-with-no-words.txt'
        ]);

        $output = $this->commandTester->getDisplay();
        Assert::assertContains('No words found in this file.', $output);
    }

    public function testWordFrequencyCounterFileWithWords()
    {
        $this->commandTester->execute([
            'source' => __DIR__.'/fixtures/file-with-words.txt'
        ]);

        $output = $this->commandTester->getDisplay();

        $expectedResult = <<<EOF
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

        Assert::assertSame($expectedResult, $output);
    }

    public function testWordFrequencyCounterDefaultLimit()
    {
        $this->commandTester->execute([
            'source' => __DIR__.'/fixtures/file-with-107-unique-words.txt'
        ]);

        $output = trim($this->commandTester->getDisplay());

        Assert::assertCount(WordFrequencyCommand::WORDS_LIMIT_DEFAULT, explode(PHP_EOL, $output));
    }

    public function testWordFrequencyCounterWithLimit()
    {
        $this->commandTester->execute([
            'source' => __DIR__.'/fixtures/file-with-words.txt',
            '--limit' => 3
        ]);

        $output = $this->commandTester->getDisplay();

        $expectedResult = <<<EOF
sells,4
she,4
seashore,3

EOF;

        Assert::assertSame($expectedResult, $output);
    }
}
