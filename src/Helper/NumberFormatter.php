<?php

namespace Justimmo\Wordpress\Helper;

class NumberFormatter
{
    public static function format($value, $min_fraction_digits = 0) {
        if($value) {
            $formatter = new \NumberFormatter(get_bloginfo("language"), \NumberFormatter::DECIMAL);
            $formatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, $min_fraction_digits);
            return $formatter->format($value);
        }
    }

    public static function formatCurrency($value, $currency, $min_fraction_digits = 2) {
        if($value) {
            $formatter = new \NumberFormatter(get_bloginfo("language"), \NumberFormatter::CURRENCY);
            $formatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, $min_fraction_digits);
            return $formatter->formatCurrency($value, $currency);
        }
    }

    public static function formatPercent($value, $min_fraction_digits = 0, $max_fraction_digits = 2) {
        if($value) {
            $formatter = new \NumberFormatter(get_bloginfo("language"), \NumberFormatter::PERCENT);
            $formatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, $min_fraction_digits);
            $formatter->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, $max_fraction_digits);
            return $formatter->format($value);
        }
    }

}
