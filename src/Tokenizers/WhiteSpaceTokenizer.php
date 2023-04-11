<?php
/**
 * @since     Apr 2023
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace Nltk\Tokenizers;

class WhiteSpaceTokenizer implements TokenizerInterface
{
    private const PATTERN = "/[\pZ\pC]+/u";

    public function tokenize(string $str): array
    {
        return array_filter(array_map(static function ($item) {
            return trim($item);
        }, preg_split(self::PATTERN, $str)));
    }
}