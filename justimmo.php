<?php

/*
  Plugin Name: JUSTIMMO API Plugin
  Plugin URI: https://github.com/justimmo/wordpress-plugin
  Description: Plugin is showing the JUSTIMMO API results
  Author: bgcc
  Version: 1.0
  Author URI: http://www.justimmo.at
  License: GPL2
  {Plugin Name} is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 2 of the License, or
  any later version.

  {Plugin Name} is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with {Plugin Name}. If not, see {License URI}.
  License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

defined('ABSPATH') or die('No script kiddies please!');

if (!defined('JI_API_WP_PLUGIN_NAME')) {
    define('JI_API_WP_PLUGIN_NAME', pathinfo(__FILE__, PATHINFO_FILENAME));
    define('JI_API_WP_PLUGIN_DIR', pathinfo(__FILE__, PATHINFO_DIRNAME));
}

include_once(JI_API_WP_PLUGIN_DIR . '/api/justimmoApiClient.class.php');
include_once(JI_API_WP_PLUGIN_DIR . '/api/justimmoObjektList.class.php');

class JiApiWpPlugin
{

    /** @var $instance JiApiWpPlugin */
    private static $instance;

    /** @var $ji_api_client justimmoApiClient */
    public $ji_api_client;

    /** @var $ji_api_client justimmoObjektList */
    public $ji_objekt_list;

    public function __construct()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        add_filter('query_vars', array($this, 'queryVars'));
        add_filter('parse_query', array($this, 'parseQuery'));

        //add_filter('rewrite_rules_array', array(&$this, 'rewriteRules'));

        add_action('init', array($this, 'init'));
        add_action('admin_menu', array($this, 'adminMenu'));
        add_action('wp_print_styles', array($this, 'addStylesheets'));

        add_action('widgets_init', array($this, 'registerSidebars'));

        add_shortcode('justimmo_list', array($this, 'justimmoListShortcode'));
        add_shortcode('justimmo_realty_list', array($this, 'realtyListShortcode'));
        add_shortcode('justimmo_search_form', array($this, 'searchFormShortcode'));

        add_action('wp_ajax_ji_api_regions', array($this, 'getAjaxRegions'));
        add_action('wp_ajax_nopriv_ji_api_regions', array($this, 'getAjaxRegions'));

        add_action('wp_ajax_ji_api_federal_states', array($this, 'getAjaxFederalStates'));
        add_action('wp_ajax_nopriv_ji_federal_states', array($this, 'getAjaxFederalStates'));

        add_action('wp_ajax_ji_api_widget_render_regions', array($this, 'renderRegions'));
        add_action('wp_ajax_nopriv_ji_api_widget_render_regions', array($this, 'renderRegions'));
    }

    /**
     * @static
     * @param string $classname
     * @return JiApiWpPlugin
     */
    public static function getInstance($classname = __CLASS__)
    {
        if (!isset(self::$instance)) {
            self::$instance = new $classname;
        }
        return self::$instance;
    }

    function queryVars($query_vars)
    {
        $new_vars = array(
            'immobilie',
            'ji_property_id',
            'ji_property_title',
            'ji_page'
        );

        return array_merge($query_vars, $new_vars);
    }

    function parseQuery()
    {
        global $wp_query;

        if (get_query_var('immobilie') != '') {
            $wp_query->is_single = false;
            $wp_query->is_page = false;
            $wp_query->is_archive = false;
            $wp_query->is_search = false;
            $wp_query->is_home = false;

            add_action('template_redirect', array(&$this, 'templateRedirect'));
        }
    }

    /*
    function rewriteRules($rules) {
        //add_rewrite_rule("immobilien/(.+?)/?$", "index.php?ji_plugin=\$matches[1]", $after = 'top');
        //add_rewrite_rule("immobilien/(.+?)/page/?([0-9]{1,})/?$", "index.php?ji_plugin=\$matches[1]&paged=\$matches[2]", $after = 'top');

        $rules[]["immobilien/(.+?)/page/?([0-9]{1,})/?$"] = "index.php?bmDomain=\$matches[1]&paged=\$matches[2]";
        $rules[]["immobilien/(.+?)$"] = "index.php?ji_plugin=index";
        $rules[]["immobilien$"] = "index.php?ji_plugin=index";
        print_r($rules);exit;
        return $rules;
    }
    */

    function getClient()
    {
        if (!$this->ji_api_client instanceof justimmoApiClient) {
            $this->ji_api_client = new justimmoApiClient(get_option('justimmo_plugin_username'), get_option('justimmo_plugin_password'));
        }

        return $this->ji_api_client;
    }

    function getObjektList()
    {
        if (!$this->ji_objekt_list instanceof justimmoObjektList) {
            $this->ji_objekt_list = new justimmoObjektList($this->getClient());
        }

        return $this->ji_objekt_list;
    }

    function setPageTitle($title = "")
    {
        $this->page_titel = $title;
        add_filter('wp_title', array(&$this, 'titleTagFilter'));
    }

    function getUrlPrefix()
    {
        return '/index.php?';
    }

    function templateRedirect()
    {
        global $wp;
        global $wp_query;

        $wp_query->is_404 = false;
        //print_r($wp_query->query_vars);exit;
        if (get_query_var('immobilie') !== '') {
            switch (get_query_var('immobilie')) {
                case 'property':
                    $this->propertyPage();
                    exit;
                    break;
                case 'expose':
                    $this->exposeDownload();
                    exit;
                    break;
                default:
                    $this->indexPage();
                    exit;
                    break;
            }
        }
    }

    function titleTagFilter($title, $separator, $separator_location)
    {
        if ($this->page_titel != null) {
            return $this->page_titel;
        }
        return $title;
    }

    function adminMenu()
    {
        add_options_page("JUSTIMMO API Settings", "JI API Settings", 1, "Settings", array(&$this, "adminOptionPage"));
    }

    function adminOptionPage()
    {
        if (!is_admin()) {
            return;
        }

        if (isset($_POST['ji_admin_form']['action']) && $_POST['ji_admin_form']['action'] == 'Y') {
            update_option('justimmo_plugin_username', $_POST['ji_admin_form']['user']);
            update_option('justimmo_plugin_password', $_POST['ji_admin_form']['password']);
            update_option('justimmo_plugin_url_prefix', $_POST['ji_admin_form']['url_prefix']);
        }

        include JI_API_WP_PLUGIN_DIR . '/admin/options.php';
    }

    function init()
    {
        // start session
        if (!session_id()) {
            session_start();
        }
    }

    function indexPage()
    {
        global $ji_api_wp_plugin;
        $ji_obj_list = $this->getObjektList();

        if ($_REQUEST['reset'] == 'filter') {
            $ji_obj_list->resetFilter();
        }

        if (isset($_REQUEST['ji_page'])) {
            $ji_obj_list->setPage($_REQUEST['ji_page']);
        }

        if (isset($_REQUEST['filter'])) {
            $ji_obj_list->mergeFilter($_REQUEST['filter']);
        }
        if (isset($_REQUEST['orderby'])) {
            $ji_obj_list->setOrderBy($_REQUEST['orderby']);
        }
        if (isset($_REQUEST['ordertype'])) {
            $ji_obj_list->setOrderType($_REQUEST['ordertype']);
        }

        //$ji_obj_list->setMaxPerPage(5);
        $objekte = $ji_obj_list->fetchList(array('picturesize=s220x155'));

        if($ji_obj_list->getTotalCount() == 1 && isset($ji_obj_list->filter['objektnummer'])) {
            header('Location: '.$this->getPropertyUrl($objekte[0]->immobilie)); exit;
        }

        $ji_obj_list->saveToSession();

        $this->setPageTitle("Immobilienliste");

        include(JI_API_WP_PLUGIN_DIR . '/templates/index.php');
    }

    function propertyPage()
    {
        global $wp_query;
        global $ji_api_wp_plugin;
        $ji_obj_list = new justimmoObjektList($this->getClient(), array());

        $pos = $_REQUEST['pos'];

        if (isset($_REQUEST['ji_property_id'])) {
            $immobilie = $ji_obj_list->fetchItemById($_REQUEST['ji_property_id']);
        } elseif ($_REQUEST['pos']) {
            $immobilie = $ji_obj_list->fetchItemByPosition($pos);
        }
        $_SESSION['ji_objekt_list']['pos'] = $pos;

        if(!$immobilie) {
            $wp_query->is_404 = true;
        }

        $this->setPageTitle($immobilie->freitexte->objekttitel);

        if (isset($_REQUEST['request'])) {
            $request_form_error = '';

            $request_form = $_REQUEST['request'];

            if (!isset($request_form['firstname']) || !$request_form['firstname']) {
                $request_form_error .= "Bitte geben Sie Ihren Vornamen ein.\n";
            }
            if (!isset($request_form['lastname']) || !$request_form['lastname']) {
                $request_form_error .= "Bitte geben Sie Ihren Nachnamen ein.\n";
            }
            if (!isset($request_form['email']) || !$request_form['email']) {
                $request_form_error .= "Bitte geben Sie ihre E-Mailadresse ein.\n";
            }
            if (!isset($request_form['message']) || !$request_form['message']) {
                $request_form_error .= "Bitte geben Sie einen Text für die Objektanfrage ein.\n";
            }
            if (function_exists('cptch_check_custom_form') && cptch_check_custom_form() !== true) {
                $request_form_error .= "Bitte füllen Sie die Sicherheitsabfrage aus.\n";
            }

            if (!$request_form_error) {
                $this->ji_api_client->pushAnfrage(
                    array(
                        'objekt_id' => $immobilie->verwaltung_techn->objektnr_intern,
                        'firstname' => $request_form['firstname'],
                        'lastname' => $request_form['lastname'],
                        'phone' => $request_form['phone'],
                        'email' => $request_form['email'],
                        'message' => $request_form['message'],
                        'address' => $request_form['address']
                    )
                );
                $request_form_success = true;
            }
        } else {
            $request_form = array(
                'firstname' => '',
                'lastname' => '',
                'email' => '',
                'phone' => '',
                'address' => '',
                'message' => 'Ich interessiere mich für die Immobilie mit der Nummer ' . $immobilie->verwaltung_techn->objektnr_extern . ' und ersuche um Kontaktaufnahme.',
            );
            $request_form_error = '';
            $request_form_success = false;
        }

        include(JI_API_WP_PLUGIN_DIR . '/templates/property.php');
    }

    function exposeDownload()
    {
        $id = $_REQUEST['ji_property_id'];
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="expose-' . $id . '-' . time() . '.pdf"');

        echo $this->getClient()->getExpose($id);
        exit;
    }

    function errorPage()
    {
        include(JI_API_WP_PLUGIN_DIR . '/templates/error.php');
    }

    function getPropertyUrl($immobilie)
    {
        $title = isset($immobilie->freitexte->objekttitel) ? $immobilie->freitexte->objekttitel : $immobilie->titel;

        $id = isset($immobilie->verwaltung_techn->objektnr_intern) ? $immobilie->verwaltung_techn->objektnr_intern :  $immobilie->id;
        $obj_nummer = isset($immobilie->verwaltung_techn->objektnr_extern) ? $immobilie->verwaltung_techn->objektnr_extern :  $immobilie->objektnummer;
        $plz = isset($immobilie->geo->plz) ? $immobilie->geo->plz :  $immobilie->plz;
        $ort = isset($immobilie->geo->ort) ? $immobilie->geo->ort :  $immobilie->ort;

        return '/immobilien/'. convert_chars_to_entities($plz.'-'.$ort.'-'.$title.'-'.$obj_nummer). '/' . $id ;

        //return $this->getUrlPrefix() . 'immobilie=property&ji_property_id=' . $id . '&ji_property_title='. convert_chars_to_entities($title);
    }

    function getIndexUrl($page = null)
    {
        if($page) {
            return '/immobilien/suchen/'.$page;
        } else {
            return '/immobilien/suchen';
        }

        //return $this->getUrlPrefix() . 'immobilie=suchen';
    }

    function getExposeUrl($id)
    {
        return $this->getUrlPrefix() . 'immobilie=expose&ji_property_id=' . $id;
    }

    function addStylesheets()
    {
        wp_register_style('jiapi_css', plugins_url('/css/jiapi.css', __FILE__));
        wp_enqueue_style('jiapi_css');

        wp_enqueue_script('justimmo-api', plugin_dir_url(__FILE__) . 'js/justimmo.js', array('jquery'), 1.0);
        wp_localize_script('justimmo-api', 'justimmoApi', array('ajaxurl' => admin_url('admin-ajax.php')));
    }

    function registerSidebars()
    {
        register_sidebar(
            array(
                'id' => 'jiapi',
                'name' => __('JUSTIMMO Sidebar'),
                'description' => __('JUSTIMMO Sidebar in der Listenansicht'),
                'before_widget' => '<div id="%1$s" class="widget-area %2$s" role="complimentary">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title">',
                'after_title' => '</h3>'
            )
        );
    }

    function realtyListShortcode($atts, $content = null)
    {
        $category = '';
        extract(shortcode_atts(array(
            'category' => '',
            'limit' => '',
            'occupancy' => '',
            'rent' => '',
            'buy' => '',
            'zip' => '',
            'realty_type_id' => '',
            'exclude_country_id' => ''
        ), $atts));

        global $ji_api_wp_plugin;
        $ji_obj_list = new justimmoObjektList($this->getClient());
        $filter = array(
            'plz_von' => $zip,
            'plz_bis' => $zip,
            'nutzungsart' => $occupancy,
            'not_land_id' => $exclude_country_id,
            'miete' => $rent,
            'kauf' => $buy,
            'objektart_id' => explode(",", $realty_type_id)
        );
        if($category) {
            $filter['tag_name'] = explode(",", $category);
        }
        $ji_obj_list->setFilter($filter);
        $ji_obj_list->setMaxPerPage($limit);
        $ji_obj_list->setOrderBy('plz');
        $ji_obj_list->setOrderType('asc');

        $objekte = $ji_obj_list->fetchList(array('picturesize=s800x600bc'));

        ob_start();
        include(JI_API_WP_PLUGIN_DIR . '/templates/_realty_list.php');
        return ob_get_clean();
    }

    function getObjektarten()
    {
        $xml = $this->getClient()->getObjektarten();

        $objektarten = array();
        foreach ($xml as $art) {
            $objektarten[(int)$art->id] = (string)$art->name;
        }

        /*
        unset($objektarten[7]);
        unset($objektarten[8]);
        unset($objektarten[11]);
        $objektarten[6] = "Gewerbe";
        */

        return $objektarten;
    }

    function searchFormShortcode($atts, $content = null)
    {
        global $ji_api_wp_plugin;

        $objektarten = $this->getObjektarten();

        ob_start();
        include(JI_API_WP_PLUGIN_DIR . '/templates/_search_form.php');
        return ob_get_clean();
    }

    function justimmoListShortcode($atts, $content = null)
    {
        global $ji_api_wp_plugin;
        $ji_obj_list = new justimmoObjektList($this->getClient());
        //$ji_obj_list->setFilter(array('tag_name' => $category));
        //$ji_obj_list->setMaxPerPage($limit);

        $objekte = $ji_obj_list->fetchList(array('picturesize=s220x155'));

        ob_start();
        include(JI_API_WP_PLUGIN_DIR . '/templates/index.php');
        return ob_get_clean();
    }

    function getAjaxFederalStates()
    {
        echo json_encode($this->getClient()->getData('/objekt/bundeslaender'));
        die();
    }

    function getAjaxRegions()
    {
        echo json_encode($this->getClient()->getRegionen());
        die();
    }

    function renderRegions()
    {
        global $ji_api_wp_plugin;

        $data = $_POST['data'];

        $regions = $this->getFilteredRegions($data);
        $ji_obj_list = $ji_api_wp_plugin->getObjektList();

        include JI_API_WP_PLUGIN_DIR . '/widget/_searchbar_regions.php';
        die();
    }

    function getFilteredRegions($data = null)
    {
        if ($data == "FOREIGN") {
            return array();
        } elseif (is_numeric($data) && intval($data) > 0) {
            return $this->getClient()->getRegionen(intval($data), 'AT')->region;
        } elseif ($data == null) {
            return $this->getClient()->getRegionen()->region;
        } else {
            return $this->getClient()->getRegionen(null, 'AT')->region;
        }
    }
}

function convert_chars_to_entities($str)
{
    $str = str_replace('À', 'A', $str);
    $str = str_replace('Á', 'A', $str);
    $str = str_replace('Â', 'A', $str);
    $str = str_replace('Ã', 'A', $str);
    $str = str_replace('Ä', 'Ae', $str);
    $str = str_replace('Å', 'A', $str);
    $str = str_replace('Æ', '&#198;', $str);
    $str = str_replace('Ç', '&#199;', $str);
    $str = str_replace('È', '&#200;', $str);
    $str = str_replace('É', '&#201;', $str);
    $str = str_replace('Ê', '&#202;', $str);
    $str = str_replace('Ë', '&#203;', $str);
    $str = str_replace('Ì', '&#204;', $str);
    $str = str_replace('Í', '&#205;', $str);
    $str = str_replace('Î', '&#206;', $str);
    $str = str_replace('Ï', '&#207;', $str);
    $str = str_replace('Ð', 'D', $str);
    $str = str_replace('Ñ', 'N', $str);
    $str = str_replace('Ò', 'O', $str);
    $str = str_replace('Ó', 'O', $str);
    $str = str_replace('Ô', 'O', $str);
    $str = str_replace('Õ', 'O', $str);
    $str = str_replace('Ö', 'Oe', $str);
    $str = str_replace('×', '&#215;', $str);  // Yeah, I know.  But otherwise the gap is confusing.  --Kris
    $str = str_replace('Ø', '&#216;', $str);
    $str = str_replace('Ù', '&#217;', $str);
    $str = str_replace('Ú', 'U', $str);
    $str = str_replace('Û', 'U', $str);
    $str = str_replace('Ü', 'Ue', $str);
    $str = str_replace('Ý', '&#221;', $str);
    $str = str_replace('Þ', '&#222;', $str);
    $str = str_replace('ß', 'ss', $str);
    $str = str_replace('à', 'a', $str);
    $str = str_replace('á', 'a', $str);
    $str = str_replace('â', 'a', $str);
    $str = str_replace('ã', 'a', $str);
    $str = str_replace('ä', 'ae', $str);
    $str = str_replace('å', 'a', $str);
    $str = str_replace('æ', '&#230;', $str);
    $str = str_replace('ç', '&#231;', $str);
    $str = str_replace('è', '&#232;', $str);
    $str = str_replace('é', '&#233;', $str);
    $str = str_replace('ê', '&#234;', $str);
    $str = str_replace('ë', '&#235;', $str);
    $str = str_replace('ì', '&#236;', $str);
    $str = str_replace('í', '&#237;', $str);
    $str = str_replace('î', '&#238;', $str);
    $str = str_replace('ï', '&#239;', $str);
    $str = str_replace('ð', '&#240;', $str);
    $str = str_replace('ñ', '&#241;', $str);
    $str = str_replace('ò', '&#242;', $str);
    $str = str_replace('ó', '&#243;', $str);
    $str = str_replace('ô', '&#244;', $str);
    $str = str_replace('õ', '&#245;', $str);
    $str = str_replace('ö', 'oe', $str);
    $str = str_replace('÷', '&#247;', $str);
    $str = str_replace('ø', '&#248;', $str);
    $str = str_replace('ù', '&#249;', $str);
    $str = str_replace('ú', 'u', $str);
    $str = str_replace('û', 'u', $str);
    $str = str_replace('ü', 'ue', $str);
    $str = str_replace('ý', 'y', $str);
    $str = str_replace('þ', '&#254;', $str);
    $str = str_replace('ÿ', 'y', $str);
    $str = str_replace(' ', '-', $str);
    $str = str_replace('|', '', $str);
    $str = str_replace(',', '', $str);
    $str = str_replace(':', '', $str);
    $str = str_replace(';', '', $str);
    $str = str_replace('!', '', $str);
    $str = str_replace('?', '', $str);

    $str = str_replace('--', '-', $str);
    $str = str_replace('--', '-', $str);
    $str = str_replace('--', '-', $str);

    return $str;
}

global $ji_api_wp_plugin;
$ji_api_wp_plugin = JiApiWpPlugin::getInstance();


include_once('JiApiWpSearchBarWidget.class.php');
