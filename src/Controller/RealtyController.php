<?php

namespace Justimmo\Wordpress\Controller;

use Justimmo\Exception\NotFoundException;
use Justimmo\Wordpress\Routing;
use Justimmo\Wordpress\Templating;

class RealtyController extends BaseController
{

    public function __construct()
    {
        parent::__construct();

        add_filter('pre_get_document_title', array($this, 'registerTitle'), 999, 2); //new WP
        add_filter('wp_title', array($this, 'registerTitle'), 999, 2); //old WP
        add_filter('aioseop_title', array($this, 'registerTitle'), 10);
    }

    /**
     * Displays single realty template
     */
    public function getDetail()
    {
        $realtyId = get_query_var('ji_realty_id', false);
        $realty   = $this->queryFactory->createRealtyQuery()->findPk($realtyId);

        $countries = $this->queryFactory->createBasicDataQuery()->findCountries();
        $cities    = $this->queryFactory->createBasicDataQuery()->getCities();

        include(Templating::getPath('realty/realty-template.php'));
    }

    public function getExpose()
    {
        $id = get_query_var('ji_realty_id');
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="expose-' . $id . '-' . time() . '.pdf"');
        echo $this->queryFactory->getApi()->callExpose($id, 'Default');
        exit;
    }

    /**
     * Displays realty search results template
     */
    public function getList()
    {
        $filter_params     = !empty($_GET['filter']) ? $_GET['filter'] : array();
        $page              = get_query_var('page', 1);
        $pager_url         = Routing::buildPagerUrl($_GET);
        $realty_list_class = '';

        $pager = $this->queryFactory->createRealtyQuery()
            ->filterByParams($filter_params)
            ->orderByParams($filter_params)
            ->paginate($page, get_option('posts_per_page', 10));


        include(Templating::getPath('search-form/search-results-template.php'));
    }

    public function shortRedirect()
    {
        $realty = $this->queryFactory->createRealtyQuery()
            ->filterByPropertyNumber(get_query_var('ji_realty_id'))
            ->findOne();

        if (empty($realty)) {
            throw new NotFoundException('Could not find realty with property number: ' . get_query_var('ji_realty_id'));
        }

        header('Location: ' . Routing::getRealtyUrl($realty));
    }

    /**
     * Property list shortcode handler
     */
    public function getShortcodeList($atts)
    {
        $atts = shortcode_atts(
            array(
                'max_per_page'       => 25,
                'rent'               => null,
                'buy'                => null,
                'type'               => null,
                'category'           => null,
                'price_min'          => null,
                'price_max'          => null,
                'rooms_min'          => null,
                'rooms_max'          => null,
                'surface_min'        => null,
                'surface_max'        => null,
                'garden'             => null,
                'garage'             => null,
                'balcony_terrace'    => null,
                'price_order'        => null,
                'date_order'         => null,
                'surface_order'      => null,
                'exclude_country_id' => null,
                'occupancy'          => null,
                'format'             => 'list',
                'zip'                => null,
            ),
            $atts,
            'ji_realty_list'
        );

        $page = get_query_var('page', 1);
        $pager_url = Routing::buildPagerUrl();

        $pager = $this->queryFactory
            ->createRealtyQuery()
            ->filterByParams($atts)
            ->orderByParams($atts)
            ->paginate($page, $atts['max_per_page']);

        $realty_list_class = $atts['format'] == 'grid' ? 'ji-realty-list--grid' : '';

        ob_start();

        include(Templating::getPath('realty/_realty-list.php'));

        return ob_get_clean();
    }

    /**
     * Search form shortcode handler
     */
    public function getShortcodeSearchForm($atts)
    {
            $realty_types = $this->queryFactory->createBasicDataQuery()->findRealtyTypes();
            $countries    = $this->queryFactory->createBasicDataQuery()->findCountries();
            $states       = array();
            $cities       = array();

            if (!empty($_GET['filter'])) {
                $filter = $_GET['filter'];
            }

            if (!empty($filter['country'])) {
                $cities = $this->queryFactory->createBasicDataQuery()->getStates($_GET['filter']['country']);
                $cities = $this->queryFactory->createBasicDataQuery()->getCities($_GET['filter']['country']);
            }

            ob_start();

            include(Templating::getPath('search-form/_search-form.php'));

            return ob_get_clean();
    }

    public function getShortcodeNumberForm($atts)
    {
        ob_start();
        include(Templating::getPath('search-form/_search-form__realty-number.php'));

        return ob_get_clean();
    }

    public function registerTitle($title)
    {
        try {
            $realty = $this->queryFactory->createRealtyQuery()->findPk(get_query_var('ji_realty_id', false));
            if (empty($realty)) {
                return $title;
            }

            $title = $realty->getTitle();
            if (empty($title)) {
                $title = $realty->getRealtyTypeName()
                         . ' '
                         . __('in', 'jiwp')
                         . ' '
                         . $realty->getCountry()
                         . ' / '
                         . $realty->getFederalState();
            }
        } catch (\Exception $e) {
            if (WP_DEBUG) {
                error_log($e->getMessage());
            }
        }

        return $title;
    }
}
