<?php

namespace Justimmo\Wordpress\Controller;

use Justimmo\Wordpress\Query\QueryFactory;

class BaseController
{
    /**
     * @var QueryFactory
     */
    protected $queryFactory;

    public function __construct()
    {
        $this->queryFactory =  new QueryFactory(get_option('ji_api_username'), get_option('ji_api_password'));
    }

    /**
     * @return array
     */
    public static function getFilterFromQueryString()
    {
        $filter = array();
        if (!empty($_GET['filter'])) {
            $filter = $_GET['filter'];
        }

        return $filter;
    }

    public static function getAscendingPriceOrderQueryString()
    {
        $queryString = remove_query_arg('filter[price_order]');
        $queryString = add_query_arg('filter[price_order]', 'asc');
        return esc_url($queryString);
    }

    public static function getDescendingPriceOrderQueryString()
    {
        $queryString = remove_query_arg('filter[price_order]');
        $queryString = add_query_arg('filter[price_order]', 'desc');
        return esc_url($queryString);
    }

    public static function getAscendingDateOrderQueryString()
    {
        $queryString = remove_query_arg('filter[created_at_order]');
        $queryString = add_query_arg('filter[created_at_order]', 'asc');
        return esc_url($queryString);
    }

    public static function getDescendingDateOrderQueryString()
    {
        $queryString = remove_query_arg('filter[created_at_order]');
        $queryString = add_query_arg('filter[created_at_order]', 'desc');
        return esc_url($queryString);
    }
}
