<?php

namespace Justimmo\Wordpress;

use Justimmo\Exception\NotFoundException;
use Justimmo\Model\Project;
use Justimmo\Model\Realty;
use Justimmo\Wordpress\Controller\ProjectController;
use Justimmo\Wordpress\Controller\RealtyController;
use Justimmo\Wordpress\Translation\CitynameTranslator;

class Routing
{
    /**
     * Register frontend rewrite rules
     */
    public function initRewriteRules()
    {
        $languageCode = substr(get_locale(), 0, 2);

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

        // realty short url rule
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
            || get_option('jiwp_language_locale') != $languageCode
        ) {
            delete_transient('rewrite_rules_check');
            update_option('jiwp_language_locale', $languageCode);
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
     * @throws \Exception
     */
    public function connectActions($template)
    {
        try {
            switch (get_query_var('ji_page', false)) {
                case 'realty':
                    $controller = new RealtyController();

                    return $controller->getDetail();
                case 'realty-expose':
                    $controller = new RealtyController();

                    return $controller->getExpose();
                case 'realty-short':
                    $controller = new RealtyController();

                    return $controller->shortRedirect();
                case 'project':
                    $controller = new ProjectController();

                    return $controller->getDetail();
                case 'realty-search':
                    $controller = new RealtyController();

                    return $controller->getList();
            }
        } catch (NotFoundException $e) {
            global $wp_query;
            $wp_query->set_404();
            status_header(404);

            return get_query_template('404');
        } catch (\Exception $e) {
            if (WP_DEBUG === true) {
                throw $e;
            }
        }

        //Fall back to original template
        return $template;
    }

    /**
     * Builds realty detail url
     * with the following format
     * <postcode>-<city>-<realty name>-<realty number>-<realty id>
     *
     * @param  Realty $realty realty object
     *
     * @return string               realty url
     */
    public static function getRealtyUrl(Realty $realty)
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
     * Builds project detail url
     * with the following format
     * <postcode>-<city>-<project name>-<project id>
     *
     * @param  Project $project project object
     *
     * @return string                 project url
     */
    public static function getProjectUrl(Project $project)
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
     * Returns url string to be used in pagination.
     *
     * @param  array $params query string parameters
     *
     * @return string url to be used by pagination partial
     */
    public static function buildPagerUrl($params = array())
    {
        $url = home_url(add_query_arg(null, null));

        if (!empty($params)) {
            $url .= '?' . http_build_query($params) . '&';
        } else {
            $url .= '?';
        }

        return $url;
    }

    /**
     * Builds realty expose detail url.
     *
     * @param  Realty $realty realty object
     *
     * @return string realty url
     */
    public static function getRealtyExposeUrl(Realty $realty)
    {
        return get_bloginfo('url') . '/realty-expose/' . $realty->getId();
    }
}
