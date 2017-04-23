<?php

/**
 * Store a "flash message" in the session.
 *
 * @param string $category The message category.
 * @param string $message The message.
 */
function flash($category, $message)
{
    $_SESSION["message"] = [$category, $message];
}


/**
 * Makes a "slugified" string.
 *
 * @param string $str The string to slugify.
 * @return string as the slugified string.
 */
function slugify($str)
{
    $str = mb_strtolower(trim($str));
    $str = str_replace(["å", "ä", "ö", " "], ["a", "a", "o", "-"], $str);
    $str = preg_replace('#[^a-zA-Z0-9-]#', '', $str);
    return $str;
}
