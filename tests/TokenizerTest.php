<?php
/**
 * @since     Mar 2023
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace NltkTest;

use Nltk\Tokenizer;
use Nltk\Tokenizers\SentenceTokenizer;
use Nltk\Tokenizers\WhiteSpaceTokenizer;
use PHPUnit\Framework\TestCase;

class TokenizerTest extends TestCase
{
    public function testTokenizerWhiteSpace(): void
    {
        $tokenizer = new WhiteSpaceTokenizer();
        $this->assertEquals(
            ['Harry', 'Potter', 'the', 'Prisoner', 'of', 'Azkaban'],
            $tokenizer->tokenize('Harry Potter the Prisoner of Azkaban')
        );
    }

    public function testTokenizerSentence(): void
    {
        $tokenizer = new SentenceTokenizer();

        $this->assertEquals(
            [
                'Harry Potter\'s overarching theme is death.',
                'In the first book, when Harry looks into the Mirror of Erised, he feels both joy and "a terrible sadness" at seeing his desire: his parents, alive and with him.',
                'Confronting their loss is central to Harry\'s character arc and manifests in different ways through the series, such as in his struggles with Dementors.',
            ],
            $tokenizer->tokenize('Harry Potter\'s overarching theme is death. In the first book, when Harry looks into the Mirror of Erised, he feels both joy and "a terrible sadness" at seeing his desire: his parents, alive and with him. Confronting their loss is central to Harry\'s character arc and manifests in different ways through the series, such as in his struggles with Dementors.')
        );
    }

    public function testTokenizerSentence2(): void
    {
        $tokenizer = new SentenceTokenizer();

        $this->assertEquals(
            [
                'Mr. Harry Potter\'s overarching theme is death.',
                'In the first book, when Harry looks into the Mirror of Erised, he feels both joy and "a terrible sadness" at seeing his desire: his parents, alive and with him.',
                'Confronting their loss is central to Harry\'s character arc and manifests in different ways through the series, such as in his struggles with Dementors.',
            ],
            $tokenizer->tokenize('Mr. Harry Potter\'s overarching theme is death. In the first book, when Harry looks into the Mirror of Erised, he feels both joy and "a terrible sadness" at seeing his desire: his parents, alive and with him. Confronting their loss is central to Harry\'s character arc and manifests in different ways through the series, such as in his struggles with Dementors.')
        );
    }
}