<?php

namespace Oenstrom\TextFilter;

/**
 * Test cases for class TextFilter.
 */
class TextFilterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test case to test the FilterException
     */
    public function testException()
    {
        $this->setExpectedException("Oenstrom\TextFilter\FilterException");
        $textFilter = new TextFilter();
        $textFilter->format("text", "markdown,ogiltigt");
    }


    /**
     * Test case to test the general text formatting method with markdown.
     */
    public function testFormat()
    {
        $filters = "markdown";
        $text = "# H1-tag";
        $textFilter = new TextFilter();

        $this->assertEquals("<h1>H1-tag</h1>\n", $textFilter->format($text, $filters));
    }


    /**
     * Test case to test the different formatting methods.
     */
    public function testFilters()
    {
        $textFilter = new textFilter();

        $this->assertEquals("hej<br />\nhej", $textFilter->nl2br("hej\nhej"));

        $this->assertEquals("<strong>hej</strong>", $textFilter->bbcode2html("[b]hej[/b]"));

        $this->assertEquals("<a href='https://google.com'>https://google.com</a>", $textFilter->makeClickable("https://google.com"));

        $this->assertEquals("alert('test');", $textFilter->strip("<script>alert('test');</script>"));

        $this->assertEquals("&gt;&lt;'&quot;&amp;åäö", $textFilter->esc("><'\"&åäö"));
        $this->assertEquals("&gt;&lt;'&quot;&amp;hej&aring;&auml;&ouml;", $textFilter->esc("><'\"&hejåäö", true));
    }
}
