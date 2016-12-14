<?php

namespace Jiwp\Extensions;

/**
 * Class that handles temporary city names translations.
 */
class CitynameTranslator
{
    /**
     * Array that contains city translations.
     *
     * @var array
     */
    private static $cityTranslations = [
        'București' => 'Bucharest',
        'Wien' => 'Viena',
    ];

    public static function translate($city)
    {
        return array_key_exists($city, self::$cityTranslations) ? self::$cityTranslations[$city] : $city;
    }
}
