# Word Frequency

Word Frequency is a command line tool that extracts the most frequent words from a text file.

It uses the Symfony Console and it was a test I submitted as the recruitment process for one of my roles.

## Usage

From the folder where Word Frequency is installed run: `./word-frequency [-l|--limit LIMIT] <source>`.

Examples:
- `./word-frequency some-file-with-text.txt`
- `./word-frequency --limit 20 some-file-with-text.txt `

If installed globally run from anywhere: `word-frequency some-file-with-text.txt` (see Installation).

## Installation

**Note:** This is just a test and the following information are for demonstration only (the project was not added to Packagist).

`composer require word-frequency/word-frequency`

If installed globally and the global composer `vendor/bin` folder is in your PATH the command `word-frequency` will be
available globally.

To install Word Frequency globally run `composer global require word-frequency/word-frequency`
