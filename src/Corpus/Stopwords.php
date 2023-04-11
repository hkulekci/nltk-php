<?php
/**
 * @since     Apr 2023
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace Nltk\Corpus;

use Nltk\Config;
use Nltk\Exceptions\MissingPackage;

class Stopwords
{
    protected string $language;
    protected array $stopwords;

    public function __construct($language = 'english')
    {
        $this->language = $language;
        $file = Config::get('DATA_DIR') . 'corpora/stopwords/' . $language;
        if (!file_exists($file)) {
            throw new MissingPackage('You need to download to use stop words!');
        }

        $content = file_get_contents($file);
        $this->stopwords = explode("\n", $content);
    }

    public function getStopwords(): array
    {
        return $this->stopwords;
    }

    public function setStopwords($stopwords): void
    {
        $this->stopwords = $stopwords;
    }

    public function stop($tokens): array
    {
        $result = [];
        foreach ($tokens as $token) {
            if (!in_array(mb_strtolower($token), $this->stopwords, true)) {
                $result[] = $token;
            }
        }

        return $result;
    }
}