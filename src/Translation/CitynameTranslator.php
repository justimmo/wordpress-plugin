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
        'Wien' => 'Vienna',
        'Niederösterreich'  => 'Lower Austria',
        'Oberösterreich'    => 'Upper Austria',
        'Steiermark'        => 'Styria',
        'Kärnten'           => 'Carinthia',
        'Tirol'             => 'Tyrol',
        'București'         => 'Bukarest',
    ];

    public static function translate($city)
    {
        return array_key_exists($city, self::$cityTranslations) ? self::$cityTranslations[$city] : $city;
    }
}
