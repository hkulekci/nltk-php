<?php
/**
 * @since     Mar 2023
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace NltkTest;

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
        $filtered = $stopwords->stop(['Harry', 'Potter', 'the', 'Prisoner', 'of', 'Azkaban']);

        $this->assertNotContains('the', $filtered);
        $this->assertNotContains('of', $filtered);
    }

    public function testStopWordFrench(): void
    {
        $stopwords = new Stopwords('french');

        $filtered = $stopwords->stop(['Est-ce', 'que', 'ce', 'musée', 'est', 'loin', 'd’ici']);

        $this->assertNotContains('que', $filtered);
        $this->assertNotContains('ce', $filtered);
        $this->assertNotContains('est', $filtered);
    }

    public function testStopWordTurkish(): void
    {
        $stopwords = new Stopwords('turkish');

        $filtered = $stopwords->stop(['Yapılması', 'gereken', 'daha', 'birkaç', 'işimiz', 'var']);

        $this->assertNotContains('data', $filtered);
        $this->assertNotContains('birkaç', $filtered);
    }
}