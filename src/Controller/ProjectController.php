<?php

namespace Justimmo\Wordpress\Controller;

use Justimmo\Exception\NotFoundException;
use Justimmo\Wordpress\Routing;
use Justimmo\Wordpress\Templating;

class ProjectController extends BaseController
{

    private static $projectInfoTemplateMapping = array(
        'address'       => 'project/_project-info__address.php',
        'contact'       => 'project/_project-info__contact.php',
        'description'   => 'project/_project-info__description.php',
        'other-info'    => 'project/_project-info__other-info.php',
        'photo-gallery' => 'project/_project-info__photo-gallery.php',
        'realties'      => 'project/_project-info__realties.php',
    );

    public function __construct()
    {
        parent::__construct();

        add_filter('pre_get_document_title', array($this, 'registerTitle'), 999, 2); //new WP
        add_filter('wp_title', array($this, 'registerTitle'), 999, 2); //old WP
        add_filter('aioseop_title', array($this, 'registerTitle'), 10);
    }

    /**
     * Displays single project template
     */
    public function getDetail()
    {
        $project_id = get_query_var('ji_project_id', false);
        $project    = $this->queryFactory->createProjectQuery()->findPk($project_id);

        include(Templating::getPath('project/project-template.php'));
    }

    /**
     * Project list shortcode handler
     */
    public function getShortcodeList($atts)
    {
        $atts = shortcode_atts(
            array(
                'max_per_page' => 5,
            ),
            $atts,
            'ji_project_list'
        );

        $page      = get_query_var('page', 1);
        $pager_url = Routing::buildPagerUrl();

        $pager = $this->queryFactory->createProjectQuery()->paginate($page, $atts['max_per_page']);

        ob_start();

        include(Templating::getPath('project/_project-list.php'));

        return ob_get_clean();
    }

    /**
     * Project info shortcode handler
     */
    public function getShortcodeInfo($atts)
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

        $project = $this->queryFactory->createProjectQuery()->findPk($atts['id']);

        if (!empty($atts['info']) && array_key_exists($atts['info'], self::$projectInfoTemplateMapping)) {
            ob_start();
            include(Templating::getPath(self::$projectInfoTemplateMapping[$atts['info']]));

            return ob_get_clean();
        }
    }


    public function registerTitle($title)
    {
        try {
            $project = $this->queryFactory->createProjectQuery()->findPk(get_query_var('ji_project_id', false));
            if (empty($project)) {
                return $title;
            }

            $projectTitle = $project->getTitle();
            if (!empty($projectTitle)) {
                return $projectTitle;
            }
        } catch (\Exception $e) {
            if (WP_DEBUG) {
                error_log($e->getMessage());
            }
        }

        return $title;
    }
}
