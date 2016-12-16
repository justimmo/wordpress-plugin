<?php

namespace Justimmo\Wordpress;

use Justimmo\Api\JustimmoApi;
use Justimmo\Api\JustimmoApiInterface;
use Psr\Log\NullLogger;
use Justimmo\Cache\NullCache;

use Justimmo\Model\Project;

use Justimmo\Model\RealtyQuery;
use Justimmo\Model\Wrapper\V1\RealtyWrapper;
use Justimmo\Model\Mapper\V1\RealtyMapper;

use Justimmo\Model\Query\BasicDataQuery;
use Justimmo\Model\Wrapper\V1\BasicDataWrapper;
use Justimmo\Model\Mapper\V1\BasicDataMapper;

use Justimmo\Model\ProjectQuery;
use Justimmo\Model\Wrapper\V1\ProjectWrapper;
use Justimmo\Model\Mapper\V1\ProjectMapper;

use Justimmo\Request\RealtyInquiryRequest;
use Justimmo\Model\Mapper\V1\RealtyInquiryMapper;

use Justimmo\Wordpress\Translation\CitynameTranslator;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 */
class Frontend
{
    const PROJECT_INFO_TEMPLATES_MAPPING = array(
        'address'       => '/project/_project-info__address.php',
        'contact'       => '/project/_project-info__contact.php',
        'description'   => '/project/_project-info__description.php',
        'other-info'    => '/project/_project-info__other-info.php',
        'photo-gallery' => '/project/_project-info__photo-gallery.php',
        'realties'      => '/project/_project-info__realties.php',
    );

    /**
     * Justimmo API client.
     *
     * @var JustimmoApiInterface
     */
    private $api;

    /**
     * Justimmo realty query object
     *
     * @var RealtyQuery
     */
    private $realtyQuery = null;

    /**
     * Justimmo project query object
     *
     * @var ProjectQuery
     */
    private $projectQuery = null;

    /**
     * Justimmo basic query object
     *
     * @var BasicDataQuery
     */
    public static $basicQuery = null;

    /**
     * Stores project in variable for use when multiple
     * instances of [ji_project_info] are used in the same page.
     *
     * @var Project
     */
    private $cachedProject;

    public function __construct()
    {
        $this->initQueryObjects(
            get_option('ji_api_username'),
            get_option('ji_api_password')
        );

        $this->initShortcodes();

        // Set php money formatting
        setlocale(LC_MONETARY, get_locale());
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     */
    public function enqueueStyles()
    {
        if (get_query_var('ji_page', false) == 'realty' || get_query_var('ji_page', false) == 'project') {

            wp_enqueue_style(
                'lightslider',
                JI_WP_PLUGIN_RESOURCES_URL . 'js/lightslider/css/lightslider.min.css',
                array(),
                Plugin::VERSION,
                'all'
            );

            wp_enqueue_style(
                'fancybox',
                JI_WP_PLUGIN_RESOURCES_URL . 'js/fancybox/jquery.fancybox.css',
                array(),
                '2.0',
                'all'
            );

        }

        wp_enqueue_style(
            Plugin::NAME,
            JI_WP_PLUGIN_RESOURCES_URL . 'css/jiwp-public.css',
            array(),
            Plugin::VERSION,
            'all'
        );

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     */
    public function enqueueScripts()
    {
        wp_deregister_script('jquery');
        wp_register_script(
            'jquery',
            JI_WP_PLUGIN_RESOURCES_URL . 'js/jquery/jquery-1.7.0.min.js',
            '1.7.0'
        );

        if (get_query_var('ji_page', false) == 'realty' || get_query_var('ji_page', false) == 'project') {
            wp_enqueue_script(
                'lightslider',
                JI_WP_PLUGIN_RESOURCES_URL . 'js/lightslider/js/lightslider.min.js',
                array('jquery'),
                Plugin::VERSION,
                true
            );

            wp_enqueue_script(
                'fancybox',
                JI_WP_PLUGIN_RESOURCES_URL . 'js/fancybox/jquery.fancybox.pack.js',
                array('jquery'),
                '2.0',
                true
            );

            wp_enqueue_script(
                'jiwp-realty-page',
                JI_WP_PLUGIN_RESOURCES_URL . 'js/jiwp-realty-page.js',
                array('lightslider'),
                Plugin::VERSION,
                true
            );

            wp_enqueue_script(
                Plugin::NAME,
                JI_WP_PLUGIN_RESOURCES_URL . 'js/jiwp-inquiry-form.js',
                array('jquery'),
                Plugin::VERSION,
                true
            );

            wp_enqueue_script(
                'jiwp-google-map',
                'https://maps.googleapis.com/maps/api/js?key=' . get_option('jiwp_google_api_key', ''),
                array('jquery'),
                Plugin::VERSION,
                true
            );
        }

        wp_enqueue_script(
            Plugin::NAME,
            JI_WP_PLUGIN_RESOURCES_URL . 'js/jiwp-search-form-widget.js',
            array('jquery'),
            Plugin::VERSION,
            true
        );

        wp_localize_script(
            Plugin::NAME,
            'Justimmo_Ajax',
            array(
                'ajax_url'   => admin_url('admin-ajax.php'),
                'ajax_nonce' => wp_create_nonce('justimmo_ajax'),
            )
        );
    }

    /**
     * Instantiates and sets Justimmo query objects if username and password are set.
     * Sets admin notice otherwise.
     *
     * @param  string $username Justimmo API username
     * @param  string $password Justimmo API password
     */
    private function initQueryObjects($username, $password)
    {
        if (!empty($username) && !empty($password)) {
            $this->api = new JustimmoApi(
                $username,
                $password,
                new NullLogger(),
                new NullCache()
            );

            $this->api->setCurlOptions(array(
                CURLOPT_TIMEOUT_MS => 60000,
            ));

            $this->realtyQuery = $this->getJustimmoRealtyQuery($this->api);
            $this->projectQuery = $this->getJustimmoProjectQuery($this->api);
            self::$basicQuery   = $this->getJustimmoBasicQuery($this->api);
        } else {
            add_action('admin_notices', array($this, 'apiCredentialsNotification'));
        }
    }

    /**
     * Shows admin notice that prompts user to complete their
     * Justimmo API credentials
     *
     * @since 1.0.0
     */
    public function apiCredentialsNotification()
    {
        $class           = 'notice notice-error';
        $message         = __('Please set your JUSTIMMO API username and password in the', 'jiwp');
        $admin_link_text = __('JUSTIMMO settings panel');

        printf('<div class="%1$s"><p>%2$s <a href=' . get_admin_url(null, 'admin.php?page=jiwp') . '>%3$s</a></p></div>', $class, $message, $admin_link_text);
    }

    /**
     * Creates and returns a Justimmo RealtyQuery instance.
     * Also sets the `culture` parameter to wordpress locale.
     *
     * @since  1.0.0
     *
     * @param JustimmoApiInterface $api Justimmo Api instance
     *
     * @return object
     */
    private function getJustimmoRealtyQuery(JustimmoApiInterface $api)
    {
        $mapper  = new RealtyMapper();
        $wrapper = new RealtyWrapper($mapper);
        $query   = new RealtyQuery($api, $wrapper, $mapper);

        $query->set('culture', $this->getLanguageCode());

        return $query;
    }

    /**
     * Creates and returns a Justimmo ProjectQuery instance.
     * Also sets the `culture` parameter to wordpress locale.
     *
     * @since  1.0.0
     *
     * @param JustimmoApiInterface $api Justimmo Api instance
     *
     * @return ProjectQuery
     */
    private function getJustimmoProjectQuery(JustimmoApiInterface $api)
    {
        $mapper  = new ProjectMapper();
        $wrapper = new ProjectWrapper($mapper);
        $query   = new ProjectQuery($api, $wrapper, $mapper);

        $query->set('culture', $this->getLanguageCode());

        return $query;
    }

    /**
     * Creates and returns a Justimmo BasicDataQuery instance
     * Also sets the `culture` parameter to wordpress locale.
     *
     * @since  1.0.0
     *
     * @param JustimmoApiInterface $api Justimmo Api instance
     *
     * @return BasicDataQuery
     */
    private function getJustimmoBasicQuery(JustimmoApiInterface $api)
    {
        $query = new BasicDataQuery($api, new BasicDataWrapper(), new BasicDataMapper());

        $query->set('culture', $this->getLanguageCode());

        return $query;
    }

    /**
     * Register frontend rewrite rules
     */
    public function initRewriteRules()
    {
        // realty detail rule
        add_rewrite_rule(
            __('properties', 'jiwp') . '/(.+)-(\d+)/?$',
            'index.php?ji_page=realty&ji_realty_id=$matches[2]',
            'top'
        );

        // realty expose rule
        add_rewrite_rule(
            'realty-expose/(\d+)/?$',
            'index.php?ji_page=realty-expose&ji_realty_id=$matches[1]',
            'top'
        );

        // realty detail rule
        add_rewrite_rule(
            __('obj', 'jiwp') . '/(\d+)/?$',
            'index.php?ji_page=realty-short&ji_realty_id=$matches[1]',
            'top'
        );

        // project detail rule
        add_rewrite_rule(
            __('projects', 'jiwp') . '/(.+)-(\d+)/?$',
            'index.php?ji_page=project&ji_project_id=$matches[2]',
            'top'
        );

        // realty search results rule
        add_rewrite_rule(
            __('properties', 'jiwp') . '/' . __('search', 'jiwp') . '/?',
            'index.php?ji_page=realty-search',
            'top'
        );


        if (get_transient('rewrite_rules_check')
            || get_option('jiwp_language_locale') != $this->getLanguageCode()
        ) {
            delete_transient('rewrite_rules_check');
            update_option('jiwp_language_locale', $this->getLanguageCode());
            flush_rewrite_rules();
        }
    }

    /**
     * Register frontend rewrite tags
     */
    public function initRewriteTags()
    {
        // add page tag (used for template switching)
        add_rewrite_tag('%ji_page%', '([^&]+)');

        // realty id tag
        add_rewrite_tag('%ji_realty_id%', '([^&]+)');

        // project id tag
        add_rewrite_tag('%ji_project_id%', '([^&]+)');
    }

    /**
     * Register frontend endpoint templates
     *
     * @param string $template default template
     *
     * @return string
     */
    public function initTemplates($template)
    {

        $screen = get_query_var('ji_page', false);

        switch ($screen) {
            case 'realty':

                $this->realtyPage();

                return;

            case 'realty-expose':

                $this->realtyExpose();
                exit;

                return;

            case 'realty-short':

                $this->realtyShortRedirect();
                exit;

                return;

            case 'project':

                $this->projectPage();

                return;

            case 'realty-search':

                $this->realtySearchResultsPage();

                return;

            default:

                break;
        }

        //Fall back to original template
        return $template;
    }

    /**
     * Displays single realty template
     */
    private function realtyPage()
    {
        $realty_id = get_query_var('ji_realty_id', false);

        $new_template = self::getTemplate('realty/realty-template.php');

        try {
            $realty = $this->getRealty($realty_id);

            $countries = self::getCountries();
            $cities    = self::getCities();

            if ($new_template) {
                include($new_template);
            }
        } catch (\Exception $e) {
            self::jiwpErrorLog($e);
        }
    }

    private function realtyExpose()
    {
        $id = get_query_var('ji_realty_id');
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="expose-' . $id . '-' . time() . '.pdf"');
        echo $this->api->callExpose($id, 'Default');
        exit;
    }

    private function realtyShortRedirect()
    {
        $realty_nb = get_query_var('ji_realty_id');
        $realty    = $this->getRealtyByNumber($realty_nb);
        header('Location: ' . $this->getRealtyUrl($realty));
    }

    /**
     * Displays single project template
     */
    private function projectPage()
    {

        $project_id = get_query_var('ji_project_id', false);

        $new_template = self::getTemplate('project/project-template.php');

        try {
            $project = $this->getProject($project_id);

            if ($new_template) {
                include($new_template);
            }
        } catch (\Exception $e) {
            self::jiwpErrorLog($e);
        }

    }

    /**
     * Displays realty search results template
     */
    private function realtySearchResultsPage()
    {
        $filter_params = $_GET['filter'];

        try {
            $this->setRealtyQueryFilters($filter_params);

            $page = get_query_var('page', 1);

            $pager_url = $this->buildPagerUrl($_GET);

            $pager = $this->getRealties($page, get_option('posts_per_page'));

            $new_template = self::getTemplate('search-form/search-results-template.php');

            if ($new_template) {
                include($new_template);
            }
        } catch (\Exception $e) {
            self::jiwpErrorLog($e);
        }
    }

    /**
     * Register shortcodes
     */
    public function initShortcodes()
    {
        // Enable shortcodes in widgets
        add_filter('widget_text', 'do_shortcode');

        add_shortcode('ji_search_form', array($this, 'searchFormShortcodeOutput'));
        add_shortcode('ji_number_search_form', array($this, 'numberSearchFormShortcodeOutput'));
        add_shortcode('ji_realty_list', array($this, 'realtyListShortcodeOutput'));
        add_shortcode('ji_project_list', array($this, 'projectListShortcodeOutput'));
        add_shortcode('ji_project_info', array($this, 'projectInfoShortcodeOutput'));
    }

    /**
     * Property list shortcode handler
     */
    public function realtyListShortcodeOutput($atts)
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

        try {
            $this->setRealtyQueryFilters($atts);

            $this->setRealtyQueryOrdering($atts);

            $page = get_query_var('page', 1);

            $pager_url = $this->buildPagerUrl();

            $pager = $this->getRealties($page, $atts['max_per_page']);

            $realty_list_class = $atts['format'] == 'grid' ? 'ji-realty-list--grid' : '';

            ob_start();
            include(JI_WP_PLUGIN_TEMPLATES_PATH . 'frontend/realty/_realty-list.php');

            return ob_get_clean();
        } catch (\Exception $e) {
            self::jiwpErrorLog($e);
        }
    }

    /**
     * Search form shortcode handler
     */
    public function searchFormShortcodeOutput($atts)
    {
        try {
            $realty_types = self::getRealtyTypes();
            $countries    = self::getCountries();
            $states       = array();
            $cities       = array();

            if (!empty($_GET['filter'])) {
                $filter = $_GET['filter'];
            }

            if (!empty($_GET['filter']) && $_GET['filter']['country']) {
                $states = self::getStates($_GET['filter']['country']);
                $cities = self::getCities($_GET['filter']['country']);
            }

            ob_start();
            include(JI_WP_PLUGIN_TEMPLATES_PATH . 'frontend/search-form/_search-form.php');

            return ob_get_clean();
        } catch (\Exception $e) {
            self::jiwpErrorLog($e);
        }
    }

    public function numberSearchFormShortcodeOutput($atts)
    {
        try {
            ob_start();
            include(JI_WP_PLUGIN_TEMPLATES_PATH . 'frontend/search-form/_search-form__realty-number.php');

            return ob_get_clean();
        } catch (\Exception $e) {
            self::jiwpErrorLog($e);
        }
    }

    /**
     * Project list shortcode handler
     */
    public function projectListShortcodeOutput($atts)
    {
        $atts = shortcode_atts(
            array(
                'max_per_page' => 5,
            ),
            $atts,
            'ji_project_list'
        );

        try {
            $this->setProjectQueryFilters($atts);

            $this->setProjectQueryOrdering($atts);

            $page = get_query_var('page', 1);

            $pager_url = $this->buildPagerUrl();

            $pager = $this->getProjects($page, $atts['max_per_page']);

            ob_start();
            include(JI_WP_PLUGIN_TEMPLATES_PATH . 'frontend/project/_project-list.php');

            return ob_get_clean();
        } catch (\Exception $e) {
            self::jiwpErrorLog($e);
        }
    }

    /**
     * Project info shortcode handler
     */
    public function projectInfoShortcodeOutput($atts)
    {
        $atts = shortcode_atts(
            array(
                'id'   => null,
                'info' => false,
            ),
            $atts,
            'ji_project_info'
        );

        if (empty($atts['id'])) {
            return;
        }

        try {
            if (!empty($this->cachedProject)) {
                $project = $this->cachedProject;
            } else {
                $project = $this->getProject($atts['id']);
            }

            if (array_key_exists($atts['info'], self::PROJECT_INFO_TEMPLATES_MAPPING)) {
                ob_start();
                include(self::getTemplate(self::PROJECT_INFO_TEMPLATES_MAPPING[$atts['info']]));

                return ob_get_clean();
            }
        } catch (\Exception $e) {
            self::jiwpErrorLog($e);
        }
    }

    /**
     * Locates template in theme folder first and then in plugin folder.
     *
     * @param  string $template_file template file
     *
     * @return string               template path
     */
    public static function getTemplate($template_file)
    {
        // Check theme directory first
        $new_template = locate_template(array('jiwp-templates/' . $template_file));

        if ($new_template != '') {
            return $new_template;
        }

        // Check plugin directory next
        $new_template = JI_WP_PLUGIN_TEMPLATES_PATH . 'frontend/' . $template_file;

        if (file_exists($new_template)) {
            return $new_template;
        }

        return false;
    }

    /**
     * Builds realty detail url
     * with the following format
     * <postcode>-<city>-<realty name>-<realty number>-<realty id>
     *
     * @param  \Realty $realty realty object
     *
     * @return string               realty url
     */
    public static function getRealtyUrl($realty)
    {
        $linkParts = array(
            sanitize_title($realty->getZipCode()),
            sanitize_title(CitynameTranslator::translate($realty->getPlace())),
            sanitize_title($realty->getTitle()),
            $realty->getPropertyNumber(),
            $realty->getId(),
        );

        return get_bloginfo('url') . '/' . __('properties', 'jiwp') . '/' . implode('-', $linkParts) . '/';
    }

    /**
     * Builds realty expose detail url.
     *
     * @param  \Realty $realty realty object
     *
     * @return string               realty url
     */
    public static function getRealtyExposeUrl($realty)
    {
        return get_bloginfo('url') . '/realty-expose/' . $realty->getId();
    }

    /**
     * Builds project detail url
     * with the following format
     * <postcode>-<city>-<project name>-<project id>
     *
     * @param  \Project $project project object
     *
     * @return string                 project url
     */
    public static function getProjectUrl($project)
    {
        $linkParts = array(
            sanitize_title($project->getZipCode()),
            sanitize_title($project->getPlace()),
            sanitize_title($project->getTitle()),
            $project->getId(),
        );

        return get_bloginfo('url') . '/' . __('projects', 'jiwp') . '/' . implode('-', $linkParts) . '/';
    }

    /**
     * Initialize widgets
     */
    public function initWidgets()
    {
        register_widget('Justimmo\\Wordpress\\Widget\\SearchForm');
    }

    /**
     * Retrieves the list of states for a certain country.
     *
     * @return partial containing state list
     */
    public function ajaxGetStates()
    {
        check_ajax_referer('justimmo_ajax', 'security');

        $states = array();

        if (!empty($_POST['country'])) {
            $states = self::getStates($_POST['country']);
        }

        include(JI_WP_PLUGIN_TEMPLATES_PATH . 'frontend/search-form/_search-form__states.php');

        wp_die();
    }

    /**
     * Currently retrieves the list of zipcodes for a certain country,
     * but should be changed in the future to retrieve actual cities.
     *
     * @return partial containing zipcodes list
     */
    public function ajaxGetCities()
    {
        check_ajax_referer('justimmo_ajax', 'security');

        $cities = array();

        if (!empty($_POST['country'])) {
            $cities = self::getCities($_POST['country']);
        }

        include(JI_WP_PLUGIN_TEMPLATES_PATH . 'frontend/search-form/_search-form__cities.php');

        wp_die();
    }

    public function ajaxSendInquiry()
    {
        check_ajax_referer('justimmo_ajax', 'security');
        parse_str($_POST['formData']);

        try {
            $api = new JustimmoApi(
                get_option('ji_api_username'),
                get_option('ji_api_password'),
                new NullLogger(),
                new NullCache()
            );

            $inquiryRequest = new RealtyInquiryRequest($api, new RealtyInquiryMapper());

            if (!empty($realty_id)) {
                $inquiryRequest->setRealtyId($realty_id);
            }

            if (!empty($contact_salutation)) {
                $inquiryRequest->setSalutationId($contact_salutation);
            }

            if (!empty($contact_title)) {
                $inquiryRequest->setTitle($contact_title);
            }

            if (!empty($contact_first_name)) {
                $inquiryRequest->setFirstName($contact_first_name);
            }

            if (!empty($contact_last_name)) {
                $inquiryRequest->setLastName($contact_last_name);
            }

            if (!empty($contact_email)) {
                $inquiryRequest->setEmail($contact_email);
            }

            if (!empty($contact_phone)) {
                $inquiryRequest->setPhone($contact_phone);
            }

            if (!empty($contact_street)) {
                $inquiryRequest->setStreet($contact_street);
            }

            if (!empty($contact_zipcode)) {
                $inquiryRequest->setZipCode($contact_zipcode);
            }

            if (!empty($contact_city)) {
                $inquiryRequest->setCity($contact_city);
            }

            if (!empty($contact_country)) {
                $inquiryRequest->setCountry($contact_country);
            }

            if (!empty($contact_message)) {
                $inquiryRequest->setMessage($contact_message);
            }

            $inquiryRequest->send();

            echo json_encode(array(
                'message' => __('Inquiry Sent!', 'jiwp'),
            ));
        } catch (\Exception $e) {
            self::jiwpErrorLog($e);
            echo json_encode(array(
                'error' => $e->getMessage(),
            ));
        }

        wp_die();
    }

    /**
     * Retrieves single realty from Justimmo API.
     *
     * @param  integer $realty_id Realty id
     *
     * @return \Realty              Realty object
     */
    private function getRealty($realty_id)
    {
        if ($this->realtyQuery == null) {
            return null;
        }

        return $this->realtyQuery->findPk($realty_id);
    }

    private function getRealtyByNumber($realty_nb)
    {
        if ($this->realtyQuery == null) {
            return null;
        }

        $this->setRealtyQueryFilters(array('objektnummer' => $realty_nb));

        return $this->realtyQuery->findOne();
    }

    /**
     * Retrieves realties from Justimmo API.
     *
     * @param  integer $page Current page
     *
     * @return \ListPager       Pager object containing realties array
     */
    private function getRealties($page, $max_per_page)
    {
        if ($this->realtyQuery == null) {
            return array();
        }

        return $this->realtyQuery->paginate($page, $max_per_page);
    }

    /**
     * Retrieves single project from Justimmo API.
     *
     * @param  integer $project_id Project id
     *
     * @return \Project             Project object
     */
    private function getProject($project_id)
    {
        if ($this->projectQuery == null) {
            return null;
        }

        return $this->projectQuery->findPk($project_id);
    }

    /**
     * Retrieves projects from Justimmo API.
     *
     * @param  integer $page Current page
     *
     * @return \ListPager       Pager object containing projects array
     */
    private function getProjects($page, $max_per_page)
    {
        if ($this->projectQuery == null) {
            return array();
        }

        return $this->projectQuery->paginate($page, $max_per_page);
    }

    /**
     * Returns states based on country id.
     *
     * @param  integer $selected_country_id Id of the selected country
     *
     * @return array                        Array of state arrays
     */
    public static function getStates($selected_country_id = null)
    {
        if (self::$basicQuery == null) {
            return array();
        }

        $states = array();

        $states = self::$basicQuery
            ->all(false)
            ->filterByCountry($selected_country_id)
            ->findFederalStates();

        return $states;
    }

    /**
     * Currently returns zipcodes based on country id,
     * but should be changed in the future to get actual cities.
     *
     * @param  integer $selected_country_id Id of the selected country.
     *
     * @return array                        Array of zipcode arrays
     */
    public static function getCities($selected_country_id = null)
    {
        if (self::$basicQuery == null) {
            return array();
        }

        $cities = array();

        $cities = self::$basicQuery
            ->all(false)
            ->filterByCountry($selected_country_id)
            ->findZipCodes();

        return $cities;
    }

    /**
     * Retrieves realty types from Justimmo API.
     *
     * @return array    Array containing realty types
     */
    public static function getRealtyTypes()
    {
        if (self::$basicQuery == null) {
            return array();
        }

        return self::$basicQuery->all(false)->findRealtyTypes();
    }

    /**
     * Retrieves countries from Justimmo API
     *
     * @return array    Array containing countries
     */
    public static function getCountries()
    {
        if (self::$basicQuery == null) {
            return array();
        }

        return self::$basicQuery->all(false)->findCountries();
    }

    /**
     * Returns url string to be used in pagination.
     *
     * @param  array $query_params query string parameters
     *
     * @return string               url to be used by pagination partial
     */
    private function buildPagerUrl($query_params = array())
    {
        $url = get_permalink();

        if (!empty($query_params)) {
            $url .= '?' . http_build_query($query_params) . '&';
        } else {
            $url .= '?';
        }

        return $url;
    }

    /**
     * Sets Realty Query filters
     *
     * @param array $filter_params Array containing the search form filter options.
     */
    private function setRealtyQueryFilters($filter_params = array())
    {
        if ($this->realtyQuery == null) {
            return;
        }

        // realty number

        if (!empty($filter_params['objektnummer'])) {
            $this->realtyQuery->filter('objektnummer', $filter_params['objektnummer']);
        }

        // rent

        if (!empty($filter_params['rent'])) {
            $this->realtyQuery->filter('miete', 1);
        }

        // buy

        if (!empty($filter_params['buy'])) {
            $this->realtyQuery->filter('kauf', 1);
        }

        // realty type

        if (!empty($filter_params['type'])) {
            $types = explode(',', $filter_params['type']);
            $this->realtyQuery->filterByRealtyTypeId($types);
        }

        // realty category

        if (!empty($filter_params['category'])) {
            $tags = explode(',', $filter_params['category']);
            $this->realtyQuery->filterByTag($tags);
        }

        // realty zipcode

        if (!empty($filter_params['zip'])) {
            $zipcodes = explode(',', $filter_params['zip']);
            $this->realtyQuery->filterByZipCode($zipcodes);
        }

        // price

        if (!empty($filter_params['price_min'])) {
            $this->realtyQuery->filterByPrice(array('min' => $filter_params['price_min']));
        }

        if (!empty($filter_params['price_max'])) {
            $this->realtyQuery->filterByPrice(array('max' => $filter_params['price_max']));
        }

        // rooms

        if (!empty($filter_params['rooms_min'])) {
            $this->realtyQuery->filterByRooms(array('min' => $filter_params['rooms_min']));
        }

        if (!empty($filter_params['rooms_max'])) {
            $this->realtyQuery->filterByRooms(array('max' => $filter_params['rooms_max']));
        }

        // surface

        if (!empty($filter_params['surface_min'])) {
            $this->realtyQuery->filterByLivingArea(array('min' => $filter_params['surface_min']));
        }

        if (!empty($filter_params['surface_max'])) {
            $this->realtyQuery->filterByLivingArea(array('max' => $filter_params['surface_max']));
        }

        // country

        if (!empty($filter_params['country'])) {
            $this->realtyQuery->filter('land_id', $filter_params['country']);
        }

        // exclude country
        if (!empty($filter_params['exclude_country_id'])) {
            $this->realtyQuery->filter('not_land_id', $filter_params['exclude_country_id']);
        }

        // federal states

        if (!empty($filter_params['states'])) {
            $this->realtyQuery->filter('bundesland_id', $filter_params['states']);
        }

        // zip codes

        if (!empty($filter_params['zip_codes'])) {
            $this->realtyQuery->filter('plz', $filter_params['zip_codes']);
        }

        // garden

        if (!empty($filter_params['garden'])) {
            $this->realtyQuery->filter('garden', 1);
        }

        // garage

        if (!empty($filter_params['garage'])) {
            $this->realtyQuery->filter('garage', 1);
        }

        // balcony

        if (!empty($filter_params['balcony_terrace'])) {
            $this->realtyQuery->filter('balkon', 1);
        }

        // occupancy

        if (!empty($filter_params['occupancy'])) {
            $this->realtyQuery->filter('nutzungsart', $filter_params['occupancy']);
        }
    }

    /**
     * Set Realty Query ordering
     *
     * @param array $order_params array containing ordering params
     */
    private function setRealtyQueryOrdering($order_params)
    {
        if ($this->realtyQuery == null) {
            return;
        }

        if (!empty($order_params['price_order'])) {
            $this->realtyQuery->orderByPrice($order_params['price_order']);
        }


        if (!empty($order_params['date_order'])) {
            $this->realtyQuery->orderByCreatedAt($order_params['date_order']);
        }


        if (!empty($order_params['surface_order'])) {
            $this->realtyQuery->orderBySurfaceArea($order_params['surface_order']);
        }
    }

    /**
     * Sets Project Query filters
     *
     * @param array $filter_params Array containing the search form filter options.
     */
    private function setProjectQueryFilters($filter_params = array())
    {
    }

    /**
     * Set Project Query ordering
     *
     * @param array $order_params array containing ordering params
     */
    private function setProjectQueryOrdering($order_params)
    {
    }

    /**
     * Helper function that logs errors in a file located in plugin's 'public' folder.
     *
     * @param  object $error error object.
     */
    public static function jiwpErrorLog($error)
    {
        file_put_contents(
            JI_WP_PLUGIN_ROOT_PATH . 'error_log', json_encode($error->getMessage()) . "\n\n",
            FILE_APPEND
        );
    }

    /**
     * Retrieve subtring of language locale.
     *
     * @return string
     */
    private function getLanguageCode()
    {
        return substr(get_locale(), 0, 2);
    }

    public function pageTitleSetup($title, $sep)
    {
        $screen = get_query_var('ji_page', false);

        if ($screen == 'realty') {
            $realty_id = get_query_var('ji_realty_id', false);

            try {
                $realty = $this->getRealty($realty_id);

                if (!empty($realty->getTitle())) {
                    $title = $realty->getTitle();
                } else {
                    $title = $realty->getRealtyTypeName()
                             . ' '
                             . __('in', 'jiwp')
                             . ' '
                             . $realty->getCountry()
                             . ' / '
                             . $realty->getFederalState();
                }
            } catch (\Exception $e) {
                self::jiwpErrorLog($e);
            }
        }

        if ($screen == 'project') {
            $project_id = get_query_var('ji_project_id', false);

            try {
                $project = $this->getProject($project_id);

                if (!empty($project->getTitle())) {
                    $title = $project->getTitle();
                }
            } catch (\Exception $e) {
                self::jiwpErrorLog($e);
            }
        }

        return $title;
    }
}
