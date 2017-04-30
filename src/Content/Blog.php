<?php

namespace Oenstrom\Content;

/**
 * Blog class for blog posts.
 */
class Blog extends Content
{
    /**
     * Get the preamble of the blog post.
     *
     * @param int $length Length of the preamble.
     * @return string as the preamble.
     */
    public function getPreamble($length = 500)
    {
        $string = strip_tags($this->data);
        if (strlen($string) > $length) {
            $stringCut = substr($string, 0, $length);
            $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . "...";
        }
        return $string;
    }
}
