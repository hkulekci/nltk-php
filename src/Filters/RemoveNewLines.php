<?php
/**
 * @since     Apr 2023
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace Nltk\Filters;

class RemoveNewLines implements FilterInterface
{
    public function filter(array $tokens): array
    {
        foreach ($tokens as $index => $token) {
            $tokens[$index] = trim(preg_replace('/\s\s+/', ' ', $token));
        }

        return $tokens;
    }
}