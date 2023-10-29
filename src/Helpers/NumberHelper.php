<?php

namespace App\Helpers;

class NumberHelper
{

    // Display the price correctly in the list of properties
    public static function price(float $number, string $sigle = '€'): string
    {
        return number_format($number, 0, '', ' ') . ' ' . $sigle;
    }
}
