<?php

namespace Oenstrom\TextFilter;

/**
 * Class for text formatting and filtering.
 */
class TextFilter
{
    /**
     * @var array   $validFilters the valid filters.
     */
    private $validFilters = [
        "nl2br" => "nl2br",
        "bbcode" => "bbcode2html",
        "link" => "makeClickable",
        "markdown" => "markdown2html",
        "strip" => "strip",
        "esc" => "esc",
    ];


    /**
     * Format a text based on specified filters.
     *
     * @param string $text The text to filter/format.
     * @param string $filters Comma separated string of filters to apply.
     * @return string as the filtered/formatted text.
     */
    public function format($text, $filters)
    {
        $filters = $this->checkFilters($filters);
        foreach ($filters as $filter) {
            $text = call_user_func_array(
                [$this, $this->validFilters[$filter]],
                [$text]
            );
        }
        return $text;
    }


    /**
     * Check if the filters are valid.
     *
     * @param string $filters the filters as a comma separated string.
     * @return array as the filters.
     */
    private function checkFilters($filters)
    {
        $filters = explode(",", $filters);
        if (array_diff($filters, array_keys($this->validFilters))) {
            throw new FilterException("Invalid filters.", 1);
        }
        return $filters;
    }


    /**
     * Converts new lines in the text to <br> tags.
     *
     * @param string $text The text to convert.
     * @return string The converted text.
     */
    public function nl2br($text)
    {
        return nl2br($text);
    }


    /**
    * Converts BBCode formatted text to HTML.
    *
    * @param string $text The text to convert.
    * @return string the formatted text.
    */
    public function bbcode2html($text)
    {
        $search = array(
            '/\[b\](.*?)\[\/b\]/is',
            '/\[i\](.*?)\[\/i\]/is',
            '/\[u\](.*?)\[\/u\]/is',
            '/\[code\](.*?)\[\/code\]/is',
            '/\[img\](https?.*?)\[\/img\]/is',
            '/\[url\](https?.*?)\[\/url\]/is',
            '/\[url=(https?.*?)\](.*?)\[\/url\]/is'
        );
        $replace = array(
            '<strong>$1</strong>',
            '<em>$1</em>',
            '<u>$1</u>',
            '<code><pre>$1</pre></code>',
            '<img src="$1" />',
            '<a href="$1">$1</a>',
            '<a href="$1">$2</a>'
        );
        return preg_replace($search, $replace, $text);
    }


    /**
     * Make clickable links from URLs in text.
     *
     * @param string $text the text that should be formatted.
     * @return string with formatted anchors.
     */
    public function makeClickable($text)
    {
        return preg_replace_callback(
            '#\b(?<![href|src]=[\'"])https?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#',
            create_function(
                '$matches',
                'return "<a href=\'{$matches[0]}\'>{$matches[0]}</a>";'
            ),
            $text
        );
    }


    /**
     * Convert markdown formatted text to HTML.
     *
     * @param string $text the markdown formatted text.
     * @return string as the converted HTML text.
     */
    public function markdown2html($text)
    {
        $markdown = new \Michelf\MarkdownExtra();
        return $markdown::defaultTransform($text);
    }


    /**
     * Remove HTML tags from the text.
     *
     * @param string $text the text to strip.
     * @return string as the text stripped from tags.
     */
    public function strip($text)
    {
        return strip_tags($text);
    }


    /**
     * Convert special characters or all applicable characters to HTML entities.
     *
     * @param string $text the text to convert.
     * @param bool $strict True uses htmlentities, false htmlspecialchars
     * @return string as the converted text.
     */
    public function esc($text, $strict = false)
    {
        return $strict ? htmlentities($text) : htmlspecialchars($text);
    }
}
