<?php

namespace Justimmo\Wordpress;

use Justimmo\Api\JustimmoApiInterface;
use Justimmo\Wordpress\Query\QueryFactory;

use Justimmo\Model\Project;

use Justimmo\Model\Query\BasicDataQuery;
use Justimmo\Model\Wrapper\V1\BasicDataWrapper;
use Justimmo\Model\Mapper\V1\BasicDataMapper;

use Justimmo\Model\ProjectQuery;
use Justimmo\Model\Wrapper\V1\ProjectWrapper;
use Justimmo\Model\Mapper\V1\ProjectMapper;

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
     * @var QueryFactory
     */
    private $queryFactory;

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

    public function __construct(QueryFactory $queryFactory)
    {
        $this->queryFactory = $queryFactory;

        $this->initShortcodes();

        // Set php money formatting
        setlocale(LC_MONETARY, get_locale());
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
     * Register shortcodes
     */
    public function initShortcodes()
    {
        add_shortcode('ji_project_list', array($this, 'projectListShortcodeOutput'));
        add_shortcode('ji_project_info', array($this, 'projectInfoShortcodeOutput'));
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
                $realty = $this->queryFactory->createRealtyQuery()->findPk($realty_id);

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
