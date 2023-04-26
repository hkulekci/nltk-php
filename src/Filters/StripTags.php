<?php
/**
 * @since     Apr 2023
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace Nltk\Filters;

class StripTags implements FilterInterface
{
    public function filter(array $tokens): array
    {
        foreach ($tokens as $index => $token) {
            $tokens[$index] = strip_tags($token);
        }

        return $tokens;
    }
}