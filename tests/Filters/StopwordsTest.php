<?php
/**
 * @since     Mar 2023
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace NltkTest\Filters;

use Nltk\Downloader;
use Nltk\Filters\Stopwords;
use PHPUnit\Framework\TestCase;

class StopwordsTest extends TestCase
{
    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        $downloader = new Downloader();
        $downloader->download('stopwords');
    }

    public function testStopWord(): void
    {
        $stopwords = new Stopwords();
        $filtered = $stopwords->filter(['Harry', 'Potter', 'the', 'Prisoner', 'of', 'Azkaban']);

        $this->assertNotContains('the', $filtered);
        $this->assertNotContains('of', $filtered);
    }

    public function testStopWordFrench(): void
    {
        $stopwords = new Stopwords(['language' => 'french']);

        $filtered = $stopwords->filter(['Est-ce', 'que', 'ce', 'musée', 'est', 'loin', 'd’ici']);

        $this->assertNotContains('que', $filtered);
        $this->assertNotContains('ce', $filtered);
        $this->assertNotContains('est', $filtered);
    }

    public function testStopWordTurkish(): void
    {
        $stopwords = new Stopwords(['language' => 'turkish']);

        $filtered = $stopwords->filter(['Yapılması', 'gereken', 'daha', 'birkaç', 'işimiz', 'var']);

        $this->assertNotContains('data', $filtered);
        $this->assertNotContains('birkaç', $filtered);
    }
}