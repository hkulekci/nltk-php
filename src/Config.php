<?php
/**
 * @since     Apr 2023
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace Nltk;

use Nltk\Exceptions\ConfigurationError;

class Config
{
    private const DEFAULTS = [
        'DATA_SERVER' => 'https://raw.githubusercontent.com/nltk/nltk_data/gh-pages/index.xml',
        'DATA_DIR' => __DIR__ . '/../data/',
    ];

    public static function get($name): bool|array|string
    {
        if (getenv($name)) {
            return getenv($name);
        }
        if (isset(self::DEFAULTS[$name])) {
            return self::DEFAULTS[$name];
        }

        throw new ConfigurationError($name . ' configuration key not found!');
    }
}