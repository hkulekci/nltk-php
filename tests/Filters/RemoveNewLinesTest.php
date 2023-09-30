<?php
/**
 * @since     Mar 2023
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */

namespace NltkTest\Filters;

use Nltk\Filters\RemoveNewLines;
use PHPUnit\Framework\TestCase;

class RemoveNewLinesTest extends TestCase
{
    public function testRemoveNewLines01(): void
    {
        $token = "
        This is a a multi line text
        And second line 
        Third line
        ";
        $stopwords = new RemoveNewLines();
        $filtered = $stopwords->filter([$token]);

        $this->assertEquals(['This is a a multi line text And second line Third line'], $filtered);
    }

    public function testRemoveNewLines02(): void
    {
        $token = "
        This is a a multi line text
        
        And second line
        
         
        Even with multiple line this should work
        ";
        $stopwords = new RemoveNewLines();
        $filtered = $stopwords->filter([$token]);

        $this->assertEquals(['This is a a multi line text And second line Even with multiple line this should work'], $filtered);
    }
}