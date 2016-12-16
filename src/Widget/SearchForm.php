<?php

namespace Justimmo\Wordpress\Widget;

use Justimmo\Wordpress\Frontend;

/**
 * Justimmo search form widget
 */
class SearchForm extends \WP_Widget
{
    public function __construct()
    {
        parent::__construct(false, 'Justimmo Search Form');
    }

    public function widget($args, $instance)
    {
        try {
            $realty_types = Frontend::getRealtyTypes();
            $countries    = Frontend::getCountries();
            $states       = array();
            $cities       = array();

            if (!empty($_GET['filter']) && !empty($_GET['filter']['country'])) {
                $states = Frontend::getStates($_GET['filter']['country']);
                $cities = Frontend::getCities($_GET['filter']['country']);
            }
        } catch (\Exception $e) {
            Frontend::jiwpErrorLog($e);
        }

        // Widget output
        include('partials/search-form/_search-form.php');
    }
}
