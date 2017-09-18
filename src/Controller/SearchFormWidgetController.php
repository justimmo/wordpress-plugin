<?php

namespace Justimmo\Wordpress\Controller;

use Justimmo\Model\Mapper\V1\RealtyInquiryMapper;
use Justimmo\Request\RealtyInquiryRequest;

class SearchFormWidgetController extends BaseController
{
    /**
     * Retrieves the list of states for a certain country.
     */
    public function ajaxGetStates()
    {
        check_ajax_referer('justimmo_ajax', 'security');

        $filter = BaseController::getFilterFromQueryString();
        $states = array();

        if (!empty($_POST['country'])) {
            $states = $this->queryFactory->createBasicDataQuery()
                ->getStates($_POST['country']);
        }

        include(JI_WP_PLUGIN_TEMPLATES_PATH . 'frontend/search-form/_search-form__states.php');

        wp_die();
    }

    /**
     * Currently retrieves the list of zipcodes for a certain country,
     * but should be changed in the future to retrieve actual cities.
     */
    public function ajaxGetCities()
    {
        check_ajax_referer('justimmo_ajax', 'security');

        $filter = BaseController::getFilterFromQueryString();
        $cities = array();

        if (!empty($_POST['country'])) {
            if (!empty($_POST['state'])) {
                $cities = $this->queryFactory->createBasicDataQuery()->getCities(
                    $_POST['country'],
                    $_POST['state']
                );
            } else {
                $cities = $this->queryFactory->createBasicDataQuery()->getCities($_POST['country']);
            }
        }

        include(JI_WP_PLUGIN_TEMPLATES_PATH . 'frontend/search-form/_search-form__cities.php');

        wp_die();
    }

    public function ajaxSendInquiry()
    {
        check_ajax_referer('justimmo_ajax', 'security');
        parse_str($_POST['formData']);

        try {
            $api = $this->queryFactory->getApi();

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
                'message' => __('Inquiry successfully sent!', 'jiwp'),
            ));
        } catch (\Exception $e) {
            echo json_encode(array(
                'error' => $e->getMessage(),
            ));
        }

        wp_die();
    }
}
