<?php

class justimmoObjektList
{
    public function __construct($ji_client, $defaults = array())
    {
        $this->ji_client = $ji_client;
        $this->max_per_page = 10;
        $this->page = 1;
        $this->total_count = 0;
        $this->defaults = $defaults;
        $this->loadFromSession();
    }

    public function setMaxPerPage($max)
    {
        $this->max_per_page = $max;
    }

    public function getMaxPerPage()
    {
        return $this->max_per_page;
    }

    public function resetFilter()
    {
        $this->filter = $this->defaults['filter'];
        $this->orderby = $this->defaults['orderby'];
        $this->page = 1;
        $this->total_count = 0;
    }

    public function loadFromSession()
    {
        if(isset($_SESSION['ji_objekt_list']))
        {
            $objekt_list_params = $_SESSION['ji_objekt_list'];
        }
        else
        {
            $objekt_list_params = $this->defaults;
        }

        $this->filter = $objekt_list_params['filter'];
        $this->orderby = $objekt_list_params['orderby'];

        if(isset($objekt_list_params['page']))
        {
            $this->page = $objekt_list_params['page'];
        }
        if(isset($objekt_list_params['total_count']))
        {
            $this->total_count = (int) $objekt_list_params['total_count'];
        }
    }

    public function saveToSession()
    {
        $_SESSION['ji_objekt_list'] = array();
        $_SESSION['ji_objekt_list']['filter'] = $this->filter;
        $_SESSION['ji_objekt_list']['page'] = $this->page;
        $_SESSION['ji_objekt_list']['orderby'] = $this->orderby;
        $_SESSION['ji_objekt_list']['total_count'] = $this->total_count;
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    public function setOrderBy($orderby)
    {
        $this->orderby = $orderby;
    }

    public function getTotalCount()
    {
        return $this->total_count;
    }

    public function fetchList($params = array())
    {
        $obj_list = $this->ji_client->getList($params, $this->filter, $this->orderby, $this->max_per_page * ($this->page -1), $this->max_per_page);
        $this->total_count = (int) $obj_list->{'query-result'}->count;
        return $obj_list;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function fetchItemById($id)
    {
        $xml = $this->ji_client->getDetail($id);
        return $xml->immobilie[0];
    }

    public function fetchItemByPosition($pos)
    {
        $obj_list = $this->ji_client->getList(array(), $this->filter, $this->orderby, $pos - 1 , 1);

        return $this->fetchItemById($obj_list->immobilie[0]->id);
    }
}
