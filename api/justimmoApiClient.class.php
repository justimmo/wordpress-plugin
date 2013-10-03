<?php

class justimmoApiClient
{
    function __construct($user1, $pass1)
    {
        $this->username = $user1;
        $this->password = $pass1;
        $this->baseUrl = 'http://api.justimmo.at/rest/v1';
        $this->debug = false;
    }

    function setDebug($state = true)
    {
        $this->debug = $state;
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

        if(curl_errno($ch) || strlen($result) < 1)
        {
            throw new Exception('Fehler bei dem Abruf der API-Daten: '.curl_errno($ch));
        }

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

    function getList($params = array(), $filter = array(), $orderby = null, $offset = 0, $limit = 0)
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

        return new SimpleXMLElement($this->loadData('/objekt/list?'.implode('&', $params)));
    }

    function getDetail($id)
    {
        return $this->getData('/objekt/detail/objekt_id/'.$id);
    }

    function getTeamList()
    {
        return $this->getData('/team/list');
    }

    function getExpose($id)
    {
        return $this->loadData('/objekt/expose?objekt_id='.$id);
    }

    function getBundeslaender()
    {
        return $this->loadData('/objekt/bundeslaender');
    }
}
