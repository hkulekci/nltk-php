<?php
/**
 * @since     Mar 2023
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace NltkTest\Filters;

use Nltk\Exceptions\ValidationError;
use Nltk\Filters\Lowercase;
use Nltk\Filters\Shingle;
use PHPUnit\Framework\TestCase;

class LowercaseTest extends TestCase
{
    public function testLowercase(): void
    {
        $shingle = new Lowercase();
        $filtered = $shingle->filter(['London', 'СТОЛИЦА РОССИИ', 'مذهل']);

        $this->assertContains('london', $filtered);
        $this->assertNotContains('London', $filtered);

        $this->assertContains('столица россии', $filtered);
        $this->assertNotContains('СТОЛИЦА РОССИИ', $filtered);

        $this->assertContains('مذهل', $filtered);
    }
}