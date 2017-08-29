<?php
/*
 * Copyright 2017 Francesco Cocchianella. All rights reserved.
 *
 * This software is proprietary and may not be copied, distributed,
 * published or used in any way, in whole or in part, without prior
 * written agreement from the author.
 */

namespace App\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use WordFrequency\WordFrequencyCounter;

class WordFrequencyCommand extends ContainerAwareCommand
{
    const WORDS_LIMIT_DEFAULT = 100;

    protected function configure()
    {
        $this->setName('word-frequency')
            ->setDescription('Lists the most frequent words from a file.')
            ->setHelp('word-frequency extracts words from a text file and lists their frequency.')
            ->addArgument('source', InputArgument::REQUIRED, 'The path to the text file.')
            ->addOption(
                'limit',
                'l',
                InputOption::VALUE_REQUIRED,
                sprintf('Limits the number of words displayed (%s by default).', static::WORDS_LIMIT_DEFAULT)
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = $input->getArgument('source');

        if (!file_exists($filePath)) {
            $output->writeln('File not found.');
            return static::EXIT_CODE_ERROR;
        }

        $text = file_get_contents($filePath);

        if (empty($text)) {
            $output->writeln('No words found in this file.');
            return static::EXIT_CODE_ERROR;
        }

        /** @var WordFrequencyCounter $wordFrequencyCounter */
        $wordFrequencyCounter = $this->getContainer()->get('word-frequency-counter');

        $mostFrequentWords = $wordFrequencyCounter->extractMostFrequentWords(
            $text,
            $input->getOption('limit') ?: static::WORDS_LIMIT_DEFAULT
        );

        array_walk(
            $mostFrequentWords,
            function(&$item, $key) {
                $item = $key . ',' . $item;
            }
        );

        $output->writeln(implode(PHP_EOL, $mostFrequentWords));

        return static::EXIT_CODE_SUCCESS;
    }
}
