<?php

namespace Applcon\Common\Library\Volt\Functions;

use function Stringy\create as s;

/**
 * \Applcon\Common\Library\Volt\Functions\Teaser
 *
 * @package Applcon\Common\Library\Volt\Functions
 */
class Teaser
{
    /**
     * Truncates the text to a given length.
     *
     * @param string $text
     * @param int    $maxLen
     * @param bool   $saveWords
     * @param string $endWith
     *
     * @return string
     */
    public static function create($text, $maxLen = 35, $saveWords = true, $endWith = ' &hellip;')
    {
        $string = s($text);
        $length = $string->length();

        if ($length <= $maxLen) {
            return $text;
        }

        $string->trimRight('. ');

        if ($saveWords) {
            while ($maxLen < $length && preg_match('/^\pL$/', $string->substr($maxLen, 1))) {
                $maxLen++;
            }
        }

        return $string->substr(0, $maxLen) . $endWith;
    }
}
