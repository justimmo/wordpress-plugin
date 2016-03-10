<?php

class justimmoApiClient
{
    private static $instance;

    public static function getInstance($classname = __CLASS__)
    {
         if (!isset(self::$instance))
         {
             self::$instance = new $classname;
         }
         return self::$instance;
    }

    function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
        $this->baseUrl = 'https://api.justimmo.at/rest/v1';
        $this->debug = false;
        $this->culture = 'de';
    }

    function setDebug($state = true)
    {
        $this->debug = $state;
    }

    function getProjektList($params = array(), $filter = array())
    {
        return new SimpleXMLElement($this->loadData('/projekt/list?'.implode('&', $this->generateParams($params, $filter))));
    }

    function getProjektDetail($id)
    {
        return new SimpleXMLElement($this->loadData('/projekt/detail?id=' . $id . '&culture=' . $this->culture));
    }

    function getProjektChoices()
    {
        return $this->loadData('/projekt/');
    }

    function generateParams($params, $filter, $orderby=null, $offset=null, $limit=null)
    {
        if(is_array($filter))
        {
            foreach ($filter as $key => $value)
            {
                if (is_array($value))
                {
                    foreach ($value as $key1 => $value1)
                    {
                        $params[] = 'filter['.$key.'][]='.$value1;
                    }
                }
                else
                {
                    $params[] = 'filter['.$key.']='.$value;
                }
            }
        }
        if($orderby)
        {
            $params[] = 'orderby='.$orderby;
        }
        if($offset)
        {
            $params[] = 'offset='.$offset;
        }
        if($limit)
        {
            $params[] = 'limit='.$limit;
        }

        $params[] = 'culture=' . $this->culture;

        return $params;
    }


    function loadData($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl.$url);
        curl_setopt($ch, CURLOPT_USERPWD, $this->username . ':' . $this->password);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

        if($this->debug)
        {
            echo "Fetch: ".$url;
        }

        $result = curl_exec($ch);
        curl_close($ch);

        if($this->debug)
        {
            echo "Fetch-Result: ".$result;
        }

        return $result;
    }


    function getData($url)
    {
        return simplexml_load_string($this->loadData($url));
    }

    function getList($params = array(), $filter = array(), $orderby = null, $offset = 0, $limit = 0, $ordertype = null)
    {
        if(is_array($filter))
        {
            foreach ($filter as $key => $value)
            {
                if (is_array($value))
                {
                    foreach ($value as $key1 => $value1)
                    {
                        $params[] = 'filter['.$key.'][]='.$value1;
                    }
                }
                else
                {
                    $params[] = 'filter['.$key.']='.$value;
                }
            }
        }

        if($orderby)
        {
            $params[] = 'orderby='.$orderby;

            if ($ordertype)
            {
                $params[] = 'ordertype='.$ordertype;
            }
            else
            {
                $params[] = 'ordertype=asc';
            }
        }
        if($offset)
        {
            $params[] = 'offset='.$offset;
        }
        if($limit)
        {
            $params[] = 'limit='.$limit;
        }

        $params[] = 'culture=' . $this->culture;

        return new SimpleXMLElement($this->loadData('/objekt/list?'.implode('&', $params)));
    }

    function getDetail($id)
    {
        return $this->getData('/objekt/detail?objekt_id=' . $id . '&culture=' . $this->culture);
    }

    function getTeamList()
    {
        return $this->getData('/team/list');
    }

    function getTeamDetail($id)
    {
        return $this->getData('/team/detail/id/' . $id);
    }

    function getExpose($id, $expose = null, $culture = 'de')
    {
        return $this->loadData('/objekt/expose?objekt_id=' . $id . ($expose ? '&expose=' . $expose : '').'&culture='.$culture);
    }

    function pushAnfrage($values)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl.'/objekt/anfrage');
        curl_setopt($ch, CURLOPT_USERPWD, $this->username . ':' . $this->password);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, implode('&', array(
            'objekt_id='.$values['objekt_id'],
            'vorname='.$values['first_name'],
            'nachname='.$values['last_name'],
            'email='.$values['email'],
            'tel='.$values['phone'],
            'message='.$values['message']
        )));

        if($this->debug)
        {
            echo "Fetch: /objekt/anfrage ";
        }

        $result = curl_exec($ch);
        curl_close($ch);

        if($this->debug)
        {
            echo "Fetch-Result: ".$result;
        }

        return $result;
    }

    function getObjektarten()
    {
        return $this->getData('/objekt/objektarten');
    }

    function getRegionen($bundesland = null, $land = null)
    {
        $params = array();
        if($bundesland) {
            $params[] = 'bundesland='.$bundesland;
        }

        if($land) {
            $params[] = 'land='.$land;
        }

        return $this->getData('/objekt/regionen?'.implode('&', $params));
    }

    function getBundeslaender($land = null)
    {
        return $this->getData('/objekt/bundeslaender');
    }

    function getLaender()
    {
        return $this->getData('/objekt/laender');
    }

    function getPlzsUndOrte($bundesland = null)
    {
        if (empty($bundesland)) {
            return $this->getData('/objekt/plzsUndOrte?alle=1');
        } else {
            return $this->getData('/objekt/plzsUndOrte?bundesland='.$bundesland);
        }
    }
}
