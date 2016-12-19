<?php

namespace Justimmo\Wordpress\Query;

use Justimmo\Model\Query\BasicDataQuery as BaseBasicDataQuery;

class BasicDataQuery extends BaseBasicDataQuery
{
    /**
     * Currently returns zipcodes based on country id,
     * but should be changed in the future to get actual cities.
     *
     * @param  integer $selectedCountryId Id of the selected country.
     *
     * @return array
     */
    public function getCities($selectedCountryId = null)
    {
        return $this
            ->filterByCountry($selectedCountryId)
            ->findZipCodes();
    }

    /**
     * Returns states based on country id.
     *
     * @param  integer $selectedCountryId Id of the selected country
     *
     * @return array
     */
    public function getStates($selectedCountryId = null)
    {
        return $this
            ->filterByCountry($selectedCountryId)
            ->findFederalStates();
    }
}
