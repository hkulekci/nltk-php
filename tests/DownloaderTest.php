<?php
/**
 * @since     Mar 2023
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace NltkTest;

use Nltk\Config;
use Nltk\Downloader;
use PHPUnit\Framework\TestCase;

class DownloaderTest extends TestCase
{
    public function testDownloader(): void
    {
        $downloader = new Downloader();
        $this->assertNotEmpty($downloader->getPackage('stopwords'));
    }

    public function testStopWord(): void
    {
        $downloader = new Downloader();
        $downloader->download('stopwords');
        $this->assertFileExists(Config::get('DATA_DIR') . 'corpora/stopwords/english');
        $this->assertFileExists(Config::get('DATA_DIR') . 'corpora/stopwords.zip');
    }
}