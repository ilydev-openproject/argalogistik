<?php

if (!function_exists('shortNumber')) {
    function shortNumber($num)
    {
        if ($num >= 1000000000000) {
            return round($num / 1000000000000, 1) . 'T';
        } elseif ($num >= 1000000000) {
            return round($num / 1000000000, 1) . 'M';
        } elseif ($num >= 1000000) {
            return round($num / 1000000, 1) . 'JT';
        } elseif ($num >= 1000) {
            return round($num / 1000, 1) . 'RB';
        }

        return $num;
    }
}
