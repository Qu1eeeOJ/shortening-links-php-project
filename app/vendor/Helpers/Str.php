<?php

namespace App\Vendor\Helpers;

class Str
{

    /**
     * Improved row generation
     *
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public static function rand($length = 16)
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;

            $bytes = random_bytes($size);

            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }

}