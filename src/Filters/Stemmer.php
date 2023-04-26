<?php
/**
 * @since     Apr 2023
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace Nltk\Filters;

class Stemmer
{
    protected string $language;

    public function __construct(array $options = [])
    {
        $this->language = $options['language'] ?? 'en';
    }
}