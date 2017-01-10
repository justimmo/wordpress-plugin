<?php

namespace Justimmo\Wordpress\Query;

use Justimmo\Api\JustimmoApi;
use Justimmo\Api\JustimmoNullApi;
use Justimmo\Cache\NullCache;
use Justimmo\Model\EmployeeQuery;
use Justimmo\Model\Mapper\V1\BasicDataMapper;
use Justimmo\Model\Mapper\V1\EmployeeMapper;
use Justimmo\Model\Mapper\V1\ProjectMapper;
use Justimmo\Model\Mapper\V1\RealtyMapper;
use Justimmo\Model\ProjectQuery;
use Justimmo\Model\Wrapper\V1\BasicDataWrapper;
use Justimmo\Model\Wrapper\V1\EmployeeWrapper;
use Justimmo\Model\Wrapper\V1\ProjectWrapper;
use Justimmo\Model\Wrapper\V1\RealtyWrapper;
use Psr\Log\NullLogger;

class QueryFactory
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var \Justimmo\Api\JustimmoApiInterface
     */
    private $api;

    /**
     * QueryFactory constructor.
     *
     * @param string $username
     * @param string $password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Returns current api instance
     *
     * @todo - configurable options for caching, logging etc
     *
     * @return \Justimmo\Api\JustimmoApiInterface
     */
    public function getApi()
    {
        if (!empty($this->api)) {
            return $this->api;
        }

        if (empty($this->username) || empty($this->password)) {
            add_action('admin_notices', array($this, 'apiCredentialsNotification'));

            return new JustimmoNullApi();
        }

        $this->api = new JustimmoApi(
            $this->username,
            $this->password,
            new NullLogger(),
            new NullCache(),
            'v1',
            substr(get_locale(), 0, 2)
        );

        $this->api->setCurlOptions(array(
            CURLOPT_TIMEOUT_MS => 60000,
        ));

        return $this->api;
    }

    /**
     * Returns a fresh RealtyQuery
     *
     * @return RealtyQuery
     */
    public function createRealtyQuery()
    {
        $mapper = new RealtyMapper();

        return new RealtyQuery($this->getApi(), new RealtyWrapper($mapper), $mapper);
    }

    /**
     * Returns a fresh ProjectQuery
     *
     * @return ProjectQuery
     */
    public function createProjectQuery()
    {
        $mapper = new ProjectMapper();

        return new ProjectQuery($this->getApi(), new ProjectWrapper($mapper), $mapper);
    }

    /**
     * Returns a fresh EmployeeQuery
     *
     * @return EmployeeQuery
     */
    public function createEmployeeQuery()
    {
        $mapper = new EmployeeMapper();

        return new EmployeeQuery($this->getApi(), new EmployeeWrapper($mapper), $mapper);
    }

    /**
     * Returns a fresh BasicDataQuery
     *
     * @return BasicDataQuery
     */
    public function createBasicDataQuery()
    {
        return new BasicDataQuery($this->getApi(), new BasicDataWrapper(), new BasicDataMapper());
    }
}
