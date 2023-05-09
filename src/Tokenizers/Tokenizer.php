<?php
/**
 * @since     Apr 2023
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace Nltk\Tokenizers;

class Tokenizer implements TokenizerInterface
{
    public function tokenize(string $str): array
    {
        return [trim($str)];
    }
}