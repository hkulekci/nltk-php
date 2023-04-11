<?php
/**
 * TokenizerInterface.php
 *
 * @since     Apr 2023
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace Nltk\Tokenizers;

interface TokenizerInterface
{
    public function tokenize(string $str): array;
}