<?php
/*
Plugin Name: Justimmo Api Plugin
Plugin URI: http://www.justimmo.at/wordpress-api-plugin
Description: Plugin is showing the Justimmo API results
Author: bgcc
Version: 1.0
Author URI: http://www.bgcc.at
*/
if (!defined('JI_API_WP_PLUGIN_NAME'))
{
    define('JI_API_WP_PLUGIN_NAME', pathinfo(__FILE__, PATHINFO_FILENAME));
    define('JI_API_WP_PLUGIN_DIR', pathinfo(__FILE__, PATHINFO_DIRNAME));
}

include_once(JI_API_WP_PLUGIN_DIR . '/api/justimmoApiClient.class.php');
include_once(JI_API_WP_PLUGIN_DIR . '/api/justimmoObjektList.class.php');

class JiApiWpPlugin
{
    /** @var $instance jiApiWpPlugin */
    private static $instance;
    /** @var $ji_api_client justimmoApiClient */
    public $ji_api_client;
    /** @var $ji_api_client justimmoObjektList */
    public $ji_objekt_list;

    public function __construct()
    {
        error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));

        //add_action('activate_justimmo/justimmo.php', array(&$this,'install'));
        //add_filter( 'page_template', 'list_page_template' );

        add_action('init', array(&$this, 'initSession'), 1);
        add_action('admin_menu', array(&$this, 'adminMenu'));
        add_action('template_redirect', array(&$this, 'templateRedirect'));
        add_action('wp_print_styles', array(&$this, 'addStylesheets'), 100);
        //add_action('init', array(&$this, 'add_my_styles'));
        //add_action('wp_header', 'jiapi');

        add_action('widgets_init', array(&$this, 'registerSidebars'));

        add_shortcode('justimmo_list', array(&$this, 'jiapi_list'));
    }

    /**
     * @static
     * @param string $classname
     * @return JiApiWpPlugin
     */
    public static function getInstance($classname = __CLASS__)
    {
        if (!isset(self::$instance))
        {
            self::$instance = new $classname;
        }
        return self::$instance;
    }

    function getClient()
    {
        if (!$this->ji_api_client instanceof justimmoApiClient)
        {
            $this->ji_api_client = new justimmoApiClient(get_option('justimmo_plugin_username'), get_option('justimmo_plugin_password'));
        }

        return $this->ji_api_client;
    }

    function getObjektList()
    {
        if (!$this->ji_objekt_list instanceof justimmoObjektList)
        {
            $this->ji_objekt_list = new justimmoObjektList($this->getClient(), $defaults);
        }

        return $this->ji_objekt_list;
    }

    function setPageTitle($title = "")
    {
        $this->page_titel = $title;
        add_filter('wp_title', array(&$this, 'titleTagFilter'));
    }

    function templateRedirect()
    {
        global $wp;
        global $wp_query;

        $tokens = explode('/', $wp->request);

        if ('immobilien-ji' != $tokens[0])
        {
            return false; // Request is not for this plugin
        }

        try {
            switch ($tokens[1])
            {
                case 'property':
                    header(':', true, 200);
                    $this->propertyPage();
                    exit;
                    break;
                case 'expose':
                    header(':', true, 200);
                    $this->exposeDownload();
                    exit;
                    break;
                default:
                    header(':', true, 200);
                    $this->indexPage();
                    exit;
                    break;
            }
        } catch (Exception $e)
        {
            header(':', true, 200);
            $this->errorPage();
            exit;
        }
    }

    function titleTagFilter($title, $separator, $separator_location)
    {
        if ($this->page_titel != null)
        {
            return $this->page_titel;
        }
        return $title;
    }

    function adminMenu()
    {
        add_options_page("Justimmo API Settings", "JI API Settings", 1, "Settings", array(&$this, "adminOptionPage"));
    }

    function adminOptionPage()
    {
        if(!is_admin())
        {
            return;
        }

        if (isset($_POST['ji_admin_form']['action']) && $_POST['ji_admin_form']['action'] == 'Y')
        {
            update_option('justimmo_plugin_username', $_POST['ji_admin_form']['user']);
            update_option('justimmo_plugin_password', $_POST['ji_admin_form']['password']);
        }

        include JI_API_WP_PLUGIN_DIR . '/admin/options.php';
    }

    function initSession()
    {
        if (!session_id())
        {
            session_start();
        }
    }

    function indexPage()
    {
        global $ji_api_wp_plugin;
        $ji_obj_list = $this->getObjektList();

        if ($_REQUEST['reset'] == 'filter')
        {
            $ji_obj_list->resetFilter();
        }

        if (isset($_REQUEST['page_ji']))
        {
            $ji_obj_list->setPage($_REQUEST['page_ji']);
        }

        if (isset($_REQUEST['filter']))
        {
            $ji_obj_list->setFilter($_REQUEST['filter']);
        }
        if (isset($_REQUEST['orderby']))
        {
            $ji_obj_list->setOrderBy($_REQUEST['orderby']);
        }

        $objekte = $ji_obj_list->fetchList(array('picturesize=s220x155'));
        $ji_obj_list->saveToSession();

        $this->setPageTitle("Immobilienliste");

        include(JI_API_WP_PLUGIN_DIR . '/templates/index.php');
    }

    function propertyPage()
    {
        global $ji_api_wp_plugin;
        $ji_obj_list = new justimmoObjektList($this->getClient(), $defaults);

        $pos = $_REQUEST['pos'];

        if (isset($_REQUEST['id']))
        {
            $immobilie = $ji_obj_list->fetchItemById($_REQUEST['id']);
        }
        elseif ($_REQUEST['pos'])
        {
            $immobilie = $ji_obj_list->fetchItemByPosition($pos);
        }
        $_SESSION['ji_objekt_list']['pos'] = $pos;

        $this->setPageTitle($immobilie->freitexte->objekttitel);

        include(JI_API_WP_PLUGIN_DIR . '/templates/property.php');
    }


    function exposeDownload()
    {
        $id = $_REQUEST['id'];
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="expose-' . $id . '-' . time() . '.pdf"');

        echo $this->getClient()->getExpose($id);
        exit;
    }

    function errorPage()
    {
        include(JI_API_WP_PLUGIN_DIR . '/templates/error.php');
    }

    function getPropertyUrl($id)
    {
        return '/immobilien-ji/property?id=' . $id;
    }

    function getIndexUrl()
    {
        return '/immobilien-ji/index';
    }

    function getExposeUrl($id)
    {
        return '/immobilien-ji/expose?id=' . $id;
    }

    function addStylesheets()
    {
        wp_register_style('jiapi_css', plugins_url('/css/jiapi.css', __FILE__));
        wp_enqueue_style('jiapi_css');
    }

    function registerSidebars()
    {
        register_sidebar(
            array(
                'id'            => 'jiapi',
                'name'          => __('Justimmo Sidebar'),
                'description'   => __('Justimmo Sidebar. Posititon in der Listenansicht'),
                'before_widget' => '<div id="%1$s" class="widget-area %2$s" role="complimentary">',
                'after_widget'  => '</div>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>'
            )
        );
    }
}

global $ji_api_wp_plugin;
$ji_api_wp_plugin = JiApiWpPlugin::getInstance();

include_once('JiApiWpSearchBarWidget.class.php');
