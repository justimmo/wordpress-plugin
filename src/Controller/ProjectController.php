<?php

namespace Justimmo\Wordpress\Controller;

use Justimmo\Model\Attachment;
use Justimmo\Model\Project;
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

    /**
     * @var Project
     */
    private $currentProject;

    public function __construct()
    {
        parent::__construct();
        $this->setupProjectSeoTags();
    }

    public function setupProjectSeoTags()
    {
        if (get_query_var('ji_page', false) == 'project') {
            try {
                $this->currentProject = $this->queryFactory->createProjectQuery()->findPk(
                    get_query_var('ji_project_id', false)
                );

                add_filter('pre_get_document_title', array($this, 'getProjectTitle'), 999, 2); //new WP
                add_filter('wp_title', array($this, 'getProjectTitle'), 999, 2); //old WP

                // Page title override for "All in One SEO Pack" Plugin
                add_filter('aioseop_title', array($this, 'getProjectTitle'), 10);

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
     * Displays single project template
     */
    public function getDetail()
    {
        if (empty($this->currentProject)) {
            $project_id = get_query_var('ji_project_id', false);
            $project    = $this->queryFactory->createProjectQuery()->findPk($project_id);
        } else {
            $project = $this->currentProject;
        }

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

    /**
     * Overrides WordPress title for project page.
     *
     * @param $title
     *
     * @return null|string
     */
    public function getProjectTitle($title)
    {
        if (empty($this->currentProject)) {
            return $title;
        }

        return $this->currentProject->getTitle();
    }

    public function getOgTitle()
    {
        return $this->getProjectTitle(null);
    }

    public function getOgDescription()
    {
        if (!empty($this->currentProject)) {
            return strip_tags($this->currentProject->getDescription());
        }

        return '';
    }

    public function getOgType($type)
    {
        return 'article';
    }

    public function getOgImage()
    {
        if (!empty($this->currentProject)) {
            /** @var Attachment[] $pictures */
            $pictures = $this->currentProject->getPictures();
            if (!empty($pictures)) {
                return $pictures[0]->getUrl();
            }
        }

        return '';
    }

    public function getOgUrl()
    {
        if (!empty($this->currentProject)) {
            return Routing::getProjectUrl($this->currentProject);
        }

        return '';
    }

    public function getOgTags()
    {
        $title = $this->getOgTitle();
        $description = $this->getOgDescription();
        $imgSrc = $this->getOgImage();
        $url = $this->getOgUrl();
        include(Templating::getPath('og-tags.php'));
    }
}
