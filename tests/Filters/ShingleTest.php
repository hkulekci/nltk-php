<?php
/**
 * @since     Mar 2023
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace NltkTest\Filters;

use Nltk\Exceptions\ValidationError;
use Nltk\Filters\Shingle;
use PHPUnit\Framework\TestCase;

class ShingleTest extends TestCase
{
    public function testShingle(): void
    {
        $shingle = new Shingle(1, 3);
        $filtered = $shingle->filter(['Harry', 'Potter', 'the', 'Prisoner', 'of', 'Azkaban']);

        $this->assertContains('the Prisoner of', $filtered);
    }

    public function testShingleWithDelimiter(): void
    {
        $shingle = new Shingle(1, 3, ',');
        $filtered = $shingle->filter(['Harry', 'Potter', 'the', 'Prisoner', 'of', 'Azkaban']);

        $this->assertContains('Harry,Potter,the', $filtered);
    }

    public function testInvalidMinMaxValue(): void
    {
        $this->expectException(ValidationError::class);
        $this->expectExceptionMessage('Min should be smaller than max!');

        new Shingle(4, 2);
    }
}