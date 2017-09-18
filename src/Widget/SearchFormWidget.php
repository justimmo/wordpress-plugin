<?php

namespace Justimmo\Wordpress\Widget;

use Justimmo\Wordpress\Controller\BaseController;
use Justimmo\Wordpress\Query\QueryFactory;
use Justimmo\Wordpress\Templating;

/**
 * Justimmo search form widget
 */
class SearchFormWidget extends \WP_Widget
{
    public function __construct()
    {
        parent::__construct('ji_search_form_widget', 'Justimmo Search Form');
    }

    public function widget($args, $instance)
    {
        $queryFactory = new QueryFactory(get_option('ji_api_username'), get_option('ji_api_password'));

        // TODO Add parameters for preselected country, state, etc in widget options
        $filter = BaseController::getFilterFromQueryString();

        try {
            $realty_types = $queryFactory->createBasicDataQuery()->findRealtyTypes();
            $countries    = $queryFactory->createBasicDataQuery()->findCountries();
            $states       = array();
            $cities       = array();

            if (!empty($filter) && !empty($filter['country'])) {
                $states = $queryFactory->createBasicDataQuery()->getStates($filter['country']);
                
                if (!empty($filter['state'])) {
                    $cities = $queryFactory->createBasicDataQuery()->getCities(
                        $filter['country'],
                        $filter['state']
                    );
                } else {
                    $cities = $queryFactory->createBasicDataQuery()->getCities($filter['country']);
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
