<?php

namespace Justimmo\Wordpress\Query;

use Justimmo\Model\RealtyQuery as BaseRealtyQuery;

class RealtyQuery extends BaseRealtyQuery
{
    /**
     * Filter by an array of params
     *
     * @param array $params Array containing the search form filter options.
     *
     * @return $this
     */
    public function filterByParams($params = array())
    {
        // realty number
        if (!empty($params['objektnummer'])) {
            $this->filterByPropertyNumber($params['objektnummer']);
        }

        // rent
        if (!empty($params['rent'])) {
            $this->filterByRent(1);
        }

        // buy
        if (!empty($params['buy'])) {
            $this->filterByBuy(1);
        }

        // realty type
        if (!empty($params['type'])) {
            $types = explode(',', $params['type']);
            $this->filterByRealtyTypeId($types);
        }

        // realty category
        if (!empty($params['category'])) {
            $tags = explode(',', $params['category']);
            $this->filterByTag($tags);
        }

        // realty zipcode
        if (!empty($params['zip'])) {
            $zipcodes = explode(',', $params['zip']);
            $this->filterByZipCode($zipcodes);
        }

        // price
        if (!empty($params['price_min'])) {
            $this->filterByPrice(array('min' => $params['price_min']));
        }
        if (!empty($params['price_max'])) {
            $this->filterByPrice(array('max' => $params['price_max']));
        }

        // rooms
        if (!empty($params['rooms_min'])) {
            $this->filterByRooms(array('min' => $params['rooms_min']));
        }
        if (!empty($params['rooms_max'])) {
            $this->filterByRooms(array('max' => $params['rooms_max']));
        }

        // surface
        if (!empty($params['surface_min'])) {
            $this->filterByLivingArea(array('min' => $params['surface_min']));
        }
        if (!empty($params['surface_max'])) {
            $this->filterByLivingArea(array('max' => $params['surface_max']));
        }

        // country
        if (!empty($params['country'])) {
            $this->filter('land_id', $params['country']);
        }

        // exclude country
        if (!empty($params['exclude_country_id'])) {
            $this->filter('not_land_id', $params['exclude_country_id']);
        }

        // federal states
        if (!empty($params['states'])) {
            $this->filter('bundesland_id', $params['states']);
        }

        // zip codes
        if (!empty($params['zip_codes'])) {
            $this->filterByZipCode($params['zip_codes']);
        }

        // garden
        if (!empty($params['garden'])) {
            $this->filter('garden', 1);
        }

        // garage
        if (!empty($params['garage'])) {
            $this->filter('garage', 1);
        }

        // balcony
        if (!empty($params['balcony_terrace'])) {
            $this->filter('balkon', 1);
        }

        // occupancy
        if (!empty($params['occupancy'])) {
            $this->filter('nutzungsart', $params['occupancy']);
        }

        return $this;
    }

    /**
     * Order by an array of params
     *
     * @param array $params array containing ordering params
     *
     * @return $this
     */
    public function orderByParams($params = array())
    {
        if (!empty($params['price_order'])) {
            $this->orderByPrice($params['price_order']);
        }

        if (!empty($params['date_order'])) {
            $this->orderByCreatedAt($params['date_order']);
        }

        if (!empty($params['surface_order'])) {
            $this->orderBySurfaceArea($params['surface_order']);
        }

        return $this;
    }
}
