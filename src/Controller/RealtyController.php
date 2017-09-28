<?php

namespace Justimmo\Wordpress\Controller;

use Justimmo\Exception\NotFoundException;
use Justimmo\Model\Attachment;
use Justimmo\Model\Realty;
use Justimmo\Pager\ListPager;
use Justimmo\Wordpress\Routing;
use Justimmo\Wordpress\Templating;

class RealtyController extends BaseController
{
    /**
     * @var Realty
     */
    private $currentRealty;

    public function __construct()
    {
        parent::__construct();
        $this->setupRealtySeoTags();
    }

    public function setupRealtySeoTags()
    {
        if (get_query_var('ji_page', false) == 'realty') {
            try {
                $this->currentRealty = $this->queryFactory->createRealtyQuery()->findPk(
                    get_query_var('ji_realty_id', false)
                );

                add_filter('pre_get_document_title', array($this, 'getRealtyTitle'), 999, 2); //new WP
                add_filter('wp_title', array($this, 'getRealtyTitle'), 999, 2); //old WP

                // Page title override for "All in One SEO Pack" Plugin
                add_filter('aioseop_title', array($this, 'getRealtyTitle'), 10);

                // Open Graph tags override for "Yoast SEO" Plugin
                add_filter('wpseo_title', array($this, 'getOgTitle'), 10);
                add_filter('wpseo_metadesc', array($this, 'getOgDescription'), 10);
                add_filter('wpseo_canonical', array($this, 'getOgUrl'), 10);
                add_filter('wpseo_opengraph_type', array($this, 'getOgType'), 10);
                add_filter('wpseo_opengraph_image', array($this, 'getOgImage'), 10);
                add_filter('wpseo_opengraph_url', array($this, 'getOgUrl'), 10);

                // Open Graph tags output
                add_action('wp_head', array($this, 'getOgTags'), 10);
            } catch (\Exception $e) {
                if (WP_DEBUG) {
                    error_log($e->getMessage());
                }
            }
        }
    }

    /**
     * Displays single realty template
     */
    public function getDetail()
    {
        if (empty($this->currentRealty)) {
            $realtyId = get_query_var('ji_realty_id', false);
            $realty = $this->queryFactory->createRealtyQuery()->findPk($realtyId);
        } else {
            $realty = $this->currentRealty;
        }

        $countries = $this->queryFactory->createBasicDataQuery()->findCountries();
        $cities = $this->queryFactory->createBasicDataQuery()->getCities();

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
        $filter_params = !empty($_GET['filter']) ? $_GET['filter'] : array();
        $page = get_query_var('page', 1);
        $pager_url = Routing::buildPagerUrl($_GET);
        $realty_list_class = '';

        $pager = $this->queryFactory->createRealtyQuery()
            ->filterByParams($filter_params)
            ->orderByParams($filter_params)
            ->paginate($page, get_option('posts_per_page', 10));

        include(Templating::getPath('search-form/search-results-template.php'));
    }

    /**
     * Realty detail short url redirect.
     *
     * @throws NotFoundException
     */
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
     * Realty list shortcode handler
     */
    public function getShortcodeList($atts)
    {
        $atts = shortcode_atts(
            array(
                'max_per_page' => 25,
                'rent' => null,
                'buy' => null,
                'type' => null,
                'category' => null,
                'price_min' => null,
                'price_max' => null,
                'rooms_min' => null,
                'rooms_max' => null,
                'surface_min' => null,
                'surface_max' => null,
                'garden' => null,
                'garage' => null,
                'balcony_terrace' => null,
                'country' => null,
                'exclude_country_id' => null,
                'occupancy' => null,
                'format' => 'list',
                'zip' => null,
                // ordering parameters
                'price_order' => null,
                'created_at_order' => null,
                'updated_at_order' => null,
                'surface_area_order' => null,
                'living_area_order' => null,
                'floor_area_order' => null,
                'number_order' => null,
                'zip_order' => null,
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

        include(Templating::getPath('realty/realty-list.php'));

        return ob_get_clean();
    }

    /**
     * Search form shortcode handler
     */
    public function getShortcodeSearchForm($atts)
    {
        $filter = BaseController::getFilterFromQueryString();
        $filter = array_merge($this->formatSearchFormAttributes($atts), $filter);

        $realty_types = $this->queryFactory->createBasicDataQuery()->findRealtyTypes();
        $countries = $this->queryFactory->createBasicDataQuery()->findCountries();
        $states = array();
        $cities = array();

        if (!empty($filter['country'])) {
            $states = $this->queryFactory->createBasicDataQuery()->getStates($filter['country']);
            if (!empty($filter['state'])) {
                $cities = $this->queryFactory->createBasicDataQuery()->getCities(
                    $filter['country'],
                    $filter['state']
                );
            } else {
                $cities = $this->queryFactory->createBasicDataQuery()->getCities($filter['country']);
            }
        }

        ob_start();

        include(Templating::getPath('search-form/_search-form.php'));

        return ob_get_clean();
    }

    /**
     * Realty number search form shortcode handler
     */
    public function getShortcodeNumberForm($atts)
    {
        ob_start();
        include(Templating::getPath('search-form/_search-form__realty-number.php'));

        return ob_get_clean();
    }

    public function getSimilarRealtiesShortCode($atts)
    {
        $atts = shortcode_atts(
            [
                'format' => 'list',
                'realty_id' => null,
                'max_nb' => 4,
                'search_by' => 'price,type,rooms,country,state,zipcode'
            ],
            $atts,
            'ji_similar_realties'
        );

        $searchCriteria = explode(',', $atts['search_by']);
        $realty = $this->queryFactory->createRealtyQuery()->findPk($atts['realty_id']);
        $params = $this->getSimilarRealtiesParameters($realty, $searchCriteria);

        $maxNb = (int)$atts['max_nb'];
        $pager = $this->queryFactory
            ->createRealtyQuery()
            ->filterByParams($params)
            ->setLimit($maxNb)
            ->paginate(1, $maxNb)
            ->setNbResults($maxNb)
            ->setMaxPerPage($maxNb);

        if (!empty($pager)) {
            $this->excludeRealtyFromResults($pager, $realty);
        }

        $realty_list_class = $atts['format'] == 'grid' ? 'ji-realty-list--grid' : '';

        ob_start();

        include(Templating::getPath('realty/similar-realties.php'));

        return ob_get_clean();
    }

    /**
     * Overrides WordPress title for realty page.
     *
     * @param $title
     *
     * @return null|string
     */
    public function getRealtyTitle($title)
    {
        if (empty($this->currentRealty)) {
            return $title;
        }

        $title = $this->currentRealty->getTitle();
        if (empty($title)) {
            $title = $this->currentRealty->getRealtyTypeName()
                . ' '
                . __('in', 'jiwp')
                . ' '
                . $this->currentRealty->getCountry()
                . ' / '
                . $this->currentRealty->getFederalState();
        }

        return $title;
    }

    public function getOgTitle()
    {
        return $this->getRealtyTitle(null);
    }

    public function getOgDescription()
    {
        if (!empty($this->currentRealty)) {
            return strip_tags($this->currentRealty->getDescription());
        }

        return '';
    }

    public function getOgType($type)
    {
        return 'article';
    }

    public function getOgImages()
    {
        $images = [];

        if (!empty($this->currentRealty)) {
            /** @var Attachment[] $pictures */
            $pictures = $this->currentRealty->getPictures();
            if (!empty($pictures)) {
                foreach ($pictures as $picture) {
                    $images[] = $picture->getUrl();
                }
            }
        }

        return $images;
    }

    public function getOgUrl()
    {
        if (!empty($this->currentRealty)) {
            return Routing::getRealtyUrl($this->currentRealty);
        }

        return '';
    }

    public function getOgTags()
    {
        $title = $this->getOgTitle();
        $description = $this->getOgDescription();
        $imgSrcs = $this->getOgImages();
        $url = $this->getOgUrl();
        include(Templating::getPath('og-tags.php'));
    }

    /**
     * @param array $atts
     *
     * @return array
     */
    private function formatSearchFormAttributes($atts = [])
    {
        if (!empty($atts['zip_codes'])) {
            $atts['zip_codes'] = explode(',', $atts['zip_codes']);
        }

        return $atts;
    }

    /**
     * @param Realty $realty
     * @param array  $searchCriteria
     *
     * @return array
     */
    protected function getSimilarRealtiesParameters(Realty $realty, $searchCriteria = [])
    {
        $params = [];

        if (in_array('price', $searchCriteria)) {
            $marketingType = $realty->getMarketingType();

            if (array_key_exists('MIETE_PACHT', $marketingType) && $marketingType['MIETE_PACHT'] == true) {
                $params['rent'] = true;
                $params['price_min'] = $realty->getTotalRent() * 0.75;
                $params['price_max'] = $realty->getTotalRent() * 1.25;
            }

            if (array_key_exists('KAUF', $marketingType) && $marketingType['KAUF'] == true) {
                $params['buy'] = true;
                $params['price_min'] = $realty->getPurchasePrice() * 0.75;
                $params['price_max'] = $realty->getPurchasePrice() * 1.25;
            }
        }

        if (in_array('type', $searchCriteria)) {
            if (!empty($realty->getRealtyTypeId())) {
                $params['type'] = $realty->getRealtyTypeId();
            }
        }

        if (in_array('rooms', $searchCriteria)) {
            if (!empty($realty->getRoomCount())) {
                $params['rooms_min'] = $realty->getRoomCount();
                $params['rooms_max'] = $realty->getRoomCount();
            }
        }

        if (in_array('country', $searchCriteria)) {
            if (!empty($realty->getCountry())) {
                $params['country'] = $this->getCountryId($realty->getCountry());
            }
        }

        if (in_array('state', $searchCriteria)) {
            if (!empty($realty->getFederalState())) {
                $params['state'] = $this->getStateId(
                    $realty->getFederalState(),
                    $this->getCountryId($realty->getCountry())
                );
            }
        }

        if (in_array('zipcode', $searchCriteria)) {
            if (!empty($realty->getZipCode())) {
                $params['zip_codes'] = $realty->getZipCode();
            }
        }

        return $params;
    }

    /**
     * @param ListPager $pager
     * @param Realty    $realty
     */
    private function excludeRealtyFromResults(ListPager $pager, Realty $realty)
    {
        foreach ($pager as $index => $pagerRealty) {
            if ($pagerRealty->getId() === $realty->getId()) {
                unset($pager[$index]);
            }
        }
    }

    /**
     * @param string $countryIso
     *
     * @return int|null
     */
    private function getCountryId($countryIso = '')
    {
        $countries = $this->queryFactory->createBasicDataQuery()->findCountries();
        foreach ($countries as $countryId => $country) {
            if (!empty($country['iso3']) === $countryIso) {
                return $countryId;
            }
        }

        return null;
    }

    /**
     * @param string $stateName
     * @param null   $countryId
     *
     * @return int|null
     */
    private function getStateId($stateName = '', $countryId = null)
    {
        $states = $this->queryFactory->createBasicDataQuery()->getStates($countryId);
        foreach ($states as $stateId => $state) {
            if ($state['name'] === $stateName) {
                return $stateId;
            }
        }

        return null;
    }
}
