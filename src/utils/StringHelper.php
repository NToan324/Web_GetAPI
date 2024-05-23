<?php

namespace App\Utils;

class StringHelper
{
    public static function randCode($length = 6)
    {
        $code = '';

        for ($i = 0; $i < $length; $i++) {
            if ($i === 0) {
                $digit = mt_rand(0, 9);
            } else {
                $digit = mt_rand(0, 9);
            }
            $code .= $digit;
        }

        return $code;
    }
}
