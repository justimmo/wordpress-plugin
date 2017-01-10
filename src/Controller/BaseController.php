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
}
