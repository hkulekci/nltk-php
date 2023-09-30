<?php
/**
 * TokenizerInterface
 *
 * @since     Apr 2023
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace Nltk\Filters;

interface FilterInterface
{
    public function filter(array $tokens): array;
}