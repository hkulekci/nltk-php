<?php
/**
 * @since     Apr 2023
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace Nltk\Filters;

class Lowercase implements FilterInterface
{
    public function filter(array $tokens): array
    {
        return array_map(static function($token) {
            return mb_strtolower($token);
        }, $tokens);
    }
}