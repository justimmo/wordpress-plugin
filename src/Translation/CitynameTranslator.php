<?php

namespace Justimmo\Wordpress\Translation;

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
        'București' => 'Bukarest',
        'Wien' => 'Vienna',
    ];

    public static function translate($city)
    {
        return array_key_exists($city, self::$cityTranslations) ? self::$cityTranslations[$city] : $city;
    }
}