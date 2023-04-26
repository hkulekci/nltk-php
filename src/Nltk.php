<?php
/**
 * @since     Apr 2023
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace Nltk;

use Nltk\Exceptions\ConfigurationError;
use Nltk\Filters\FilterInterface;
use Nltk\Tokenizers\TokenizerInterface;

class Nltk
{
    protected TokenizerInterface $tokenizer;
    /** @var FilterInterface[] $postFilters */
    protected array $postFilters = [];
    /** @var FilterInterface[] $preFilters */
    protected array $preFilters = [];

    public function __construct(string $tokenizer, array $postFilters = [], array $preFilters = [])
    {
        if (!class_exists($tokenizer)) {
            throw new ConfigurationError('Missing tokenizer ['.$tokenizer.']');
        }
        $this->tokenizer = new $tokenizer();
        foreach ($postFilters as $filter => $value) {
            if (!class_exists($filter)) {
                throw new ConfigurationError('Missing filter ['.$filter.']');
            }
            $this->postFilters[] = new $filter($value);
        }
        foreach ($preFilters as $filter => $value) {
            if (!class_exists($filter)) {
                throw new ConfigurationError('Missing filter ['.$filter.']');
            }
            $this->preFilters[] = new $filter($value);
        }
    }

    public function process(string $text): array
    {
        $text = [$text];
        foreach ($this->preFilters as $filter) {
            $text = $filter->filter($text);
        }
        $tokens = $this->tokenizer->tokenize(implode(' ', $text));
        foreach ($this->postFilters as $filter) {
            $tokens = $filter->filter($tokens);
        }

        return $tokens;
    }
}