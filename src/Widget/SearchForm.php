<?php

namespace Justimmo\Wordpress\Widget;

use Justimmo\Wordpress\Query\QueryFactory;
use Justimmo\Wordpress\Templating;

/**
 * Justimmo search form widget
 */
class SearchForm extends \WP_Widget
{
    public function __construct()
    {
        parent::__construct('ji_search_form_widget', 'Justimmo Search Form');
    }

    public function widget($args, $instance)
    {
        $queryFactory = new QueryFactory(get_option('ji_api_username'), get_option('ji_api_password'));

        if (!empty($_GET['filter'])) {
            $filter = $_GET['filter'];
        }

        try {
            $realty_types = $queryFactory->createBasicDataQuery()->findRealtyTypes();
            $countries    = $queryFactory->createBasicDataQuery()->findCountries();
            $states       = array();
            $cities       = array();

            if (!empty($_GET['filter']) && !empty($_GET['filter']['country'])) {
                $states = $queryFactory->createBasicDataQuery()->getStates($_GET['filter']['country']);
                
                if (!empty($_GET['filter']['state'])) {
                    $cities = $queryFactory->createBasicDataQuery()->getCities(
                        $_GET['filter']['country'],
                        $_GET['filter']['state']
                    );
                } else {
                    $cities = $queryFactory->createBasicDataQuery()->getCities($_GET['filter']['country']);
                }
            }
        } catch (\Exception $e) {
            if (WP_DEBUG) {
                throw $e;
            }
        }

        include(Templating::getPath('search-form/_search-form.php'));
    }
}
