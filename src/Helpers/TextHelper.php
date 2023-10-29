<?php

namespace App\Helpers;

class TextHelper
{

    // Get an extract of the property description to display in the property listing
    public static function excerpt(string $content, int $limit = 60)
    {
        if (mb_strlen($content) <= $limit) {
            return $content;
        }
        $lastSpace = mb_strpos($content, ' ', $limit);
        return mb_substr($content, 0, $lastSpace) . '...';
    }
}
