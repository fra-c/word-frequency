<?php
/*
 * Copyright 2017 Francesco Cocchianella. All rights reserved.
 *
 * This software is proprietary and may not be copied, distributed,
 * published or used in any way, in whole or in part, without prior
 * written agreement from the author.
 */

namespace App\Command;

use App\TextLoader\Exception\EmptyTextException;
use App\TextLoader\Exception\FileNotFoundException;
use App\TextLoader\TextLoader;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use WordFrequency\WordFrequencyCounter;

class WordFrequencyCommand extends ContainerAwareCommand
{
    const WORDS_LIMIT_DEFAULT = 100;

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var TextLoader $textLoader */
        $textLoader = $this->getContainer()->get('app.text-loader');

        $filePath = $input->getArgument('source');

        try {
            $text = $textLoader->load($filePath);
        } catch (FileNotFoundException $exception) {
            $output->writeln(sprintf('File "%s" not found.', $filePath));
            return static::EXIT_CODE_ERROR;
        } catch (EmptyTextException $exception) {
            $output->writeln(sprintf('"%s" is an empty file.', $filePath));
            return static::EXIT_CODE_ERROR;
        }

        /** @var WordFrequencyCounter $wordFrequencyCounter */
        $wordFrequencyCounter = $this->getContainer()->get('word-frequency.word-frequency-counter');

        $mostFrequentWords = $wordFrequencyCounter->extractMostFrequentWords(
            $text,
            $input->getOption('limit') ?: static::WORDS_LIMIT_DEFAULT
        );

        if (empty($mostFrequentWords)) {
            $output->writeln(sprintf('No words found in "%s".', $filePath));
            return static::EXIT_CODE_ERROR;
        }

        // Concatenate each $mostFrequentWords item to make a comma separated list (word,count)
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
