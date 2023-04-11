<?php
/**
 * @since     Apr 2023
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace Nltk;

use GuzzleHttp\Client;
use Nltk\Exceptions\MissingCollection;
use Nltk\Exceptions\MissingPackage;
use Nltk\Exceptions\UnzipException;
use SimpleXMLElement;
use ZipArchive;

class Downloader
{
    private Client $httpClient;

    private $packages = [];
    private $collections = [];

    public function __construct()
    {
        $this->httpClient = new Client();

        $this->downloadServerInfo();
    }

    private function downloadServerInfo(): void
    {
        $response = $this->httpClient->get(Config::get('DATA_SERVER'));

        try {
            $info = new SimpleXMLElement($response->getBody()->getContents());
            foreach ($info->packages->package as $package) {
                $this->packages[(string)$package['id']] = [
                    'id' => (string)$package['id'],
                    'name' => (string)$package['name'],
                    'version' => (string)$package['version'] ?: '',
                    'license' => (string)$package['license'] ?: '',
                    'copyright' => (string)$package['copyright'] ?: '',
                    'webpage' => (string)$package['webpage'] ?: '',
                    'author' => (string)$package['author'],
                    'languages' => (string)$package['languages'],
                    'unzip' => (string)$package['unzip'],
                    'unzipped_size' => (string)$package['unzipped_size'],
                    'size' => (string)$package['size'],
                    'checksum' => (string)$package['checksum'],
                    'subdir' => (string)$package['subdir'],
                    'url' => (string)$package['url'],
                ];
            }

            foreach ($info->collections->collection as $collection) {
                $c = [
                    'id' => (string)$package['id'],
                    'name' => (string)$package['name'],
                    'items' => [],
                ];
                foreach ($collection->item as $item) {
                    $c['items'][] = (string)$item['ref'];
                }

                $this->collections[(string)$collection['id']] = $c;
            }
        } catch (\Exception $e) {
        }
    }

    public function getPackage(string $id): array
    {
        if (!isset($this->packages[$id])) {
            throw new MissingPackage($id . ' is missing!');
        }
        return $this->packages[$id];
    }

    public function getCollection(string $id): array
    {
        if (!isset($this->packages[$id])) {
            throw new MissingCollection($id . ' is missing!');
        }
        return $this->collections[$id];
    }

    public function download($id): void
    {
        $info = $this->getPackage($id);
        $folder = Config::get('DATA_DIR') . $info['subdir'] . DIRECTORY_SEPARATOR;
        $file = $folder . $info['id'] . '.zip';

        if (file_exists($file)) {
            return;
        }

        if (!file_exists($folder)) {
            if (!mkdir($folder, 0777,true) && !is_dir($folder)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $folder));
            }
        }

        $resource = \GuzzleHttp\Psr7\Utils::tryFopen(
            $file, 'w'
        );
        $this->httpClient->request('GET', $info['url'], ['sink' => $resource]);

        $zip = new ZipArchive();
        $res = $zip->open($file);
        if ($res === true) {
            $zip->extractTo($folder);
            $zip->close();
        } else {
            throw new UnzipException('Unzip operation not worked as expected!');
        }
    }
}