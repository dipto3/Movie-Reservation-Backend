<?php

use Illuminate\Support\Facades\Log;

function format_bdt($number, $decimals = 0, $symbol = '৳')
{
    $parts = explode('.', number_format($number, $decimals, '.', ''));

    $integerPart = $parts[0];
    $decimalPart = isset($parts[1]) ? $parts[1] : null;

    // Get the last 3 digits
    $lastThree = substr($integerPart, -3);
    $restUnits = substr($integerPart, 0, -3);

    if ($restUnits != '') {
        $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
        $formatted = $restUnits . ',' . $lastThree;
    } else {
        $formatted = $lastThree;
    }

    if ($decimals > 0 && $decimalPart) {
        $formatted .= '.' . $decimalPart;
    }

    return $formatted . $symbol;
}

if (!function_exists('formatNumber')) {
    /**
     * Format phone number.
     * @param string $number The phone number to format.
     * @return string The formatted phone number.
     */
    function formatNumber($number)
    {
        if ($number) {
            $number = str_replace([' ', '-', '(', ')'], '', $number);
            return preg_replace('/^(?:\+?880|0)?/', '+880', $number);
        }
        return $number;
    }
}

if (!function_exists('formatNumberWithouCode')) {
    /**
     * Format phone number.
     * @param string $number The phone number to format.
     * @return string The formatted phone number.
     */
    function formatNumberWithouCode($number)
    {
        if ($number) {
            $number = str_replace([' ', '-', '(', ')'], '', $number);
            return preg_replace('/^(?:\+?880|0)?/', '0', $number);
        }
        return $number;
    }
}

if (!function_exists('numberToWords')) {
    /**
     * Convert number to words.
     * @param int $num The number to convert.
     * @return string The number converted to words.
     */
    function numberToWords($num)
    {
        $ones = [
            0 => "zero",
            1 => "one",
            2 => "two",
            3 => "three",
            4 => "four",
            5 => "five",
            6 => "six",
            7 => "seven",
            8 => "eight",
            9 => "nine",
            10 => "ten",
            11 => "eleven",
            12 => "twelve",
            13 => "thirteen",
            14 => "fourteen",
            15 => "fifteen",
            16 => "sixteen",
            17 => "seventeen",
            18 => "eighteen",
            19 => "nineteen"
        ];

        $tens = [
            2 => "twenty",
            3 => "thirty",
            4 => "forty",
            5 => "fifty",
            6 => "sixty",
            7 => "seventy",
            8 => "eighty",
            9 => "ninety"
        ];

        $thousands = ["", "thousand", "million", "billion", "trillion"];

        if ($num == 0) {
            return "Zero";
        }

        $words = "";
        $i = 0;

        while ($num > 0) {
            $rem = $num % 1000;
            if ($rem != 0) {
                $str = "";
                if ($rem >= 100) {
                    $str .= $ones[(int)($rem / 100)] . " hundred ";
                    $rem %= 100;
                }
                if ($rem > 0) {
                    if ($rem < 20) {
                        $str .= $ones[$rem] . " ";
                    } else {
                        $str .= $tens[(int)($rem / 10)] . " ";
                        if ($rem % 10 > 0) {
                            $str .= $ones[$rem % 10] . " ";
                        }
                    }
                }
                $words = $str . $thousands[$i] . " " . $words;
            }
            $num = (int)($num / 1000);
            $i++;
        }

        return ucfirst(trim($words));
    }
}

if (!function_exists('getMyBranch')) {
    /**
     * Convert number to words.
     * @param int $num The number to convert.
     * @return string The number converted to words.
     */
    function getMyBranch(): array
    {
        return auth('admin-api')->user()->branches->pluck('id')->toArray();
    }
}

if (!function_exists('generateBase64Image')) {
    /**
     * Convert number to words.
     * @param int $num The number to convert.
     * @return string The number converted to words.
     */
    function generateBase64Image(): string
    {
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8Xw8AAuMBgkWnSrwAAAAASUVORK5CYII=';
    }
}

if (!function_exists('getCurrentConcern')) {
    /**
     * Get the current user's concern ID.
     * @return int|null The current user's concern ID or null.
     */
    function getCurrentConcern(): ?int
    {
        return 1;
    }
}
