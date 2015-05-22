<?php

class justimmoObjektList
{
    public function __construct($ji_client, $defaults = array('filter' => array(), 'orderby' => 'objektnummer', 'ordertype' => 'desc'))
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
        $this->ordertype = $this->defaults['ordertype'];
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
        $this->ordertype = $objekt_list_params['ordertype'];

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
        $_SESSION['ji_objekt_list']['ordertype'] = $this->ordertype;
        $_SESSION['ji_objekt_list']['total_count'] = $this->total_count;
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    public function mergeFilter($filter)
    {
        $this->filter = $filter + $this->filter;
    }

    public function setOrderBy($orderby)
    {
        $this->orderby = $orderby;
    }

    public function setOrderType($ordertype)
    {
        $this->ordertype = $ordertype;
    }

    public function getTotalCount()
    {
        return $this->total_count;
    }

    public function fetchList($params = array())
    {
        $filter = $this->filter;

        if(isset($filter['bundesland_id'])) {
            if($filter['bundesland_id'] == "") {
                unset($filter['bundesland_id']);
            } elseif($filter['bundesland_id'] == "FOREIGN") {
                $filter['not_land_id'] = 17;
                unset($filter['bundesland_id']);
            } elseif(isset($filter['bundesland_id']) && !is_numeric($filter['bundesland_id'])) {
                $filter['land_iso2'] = $filter['bundesland_id'];
                unset($filter['bundesland_id']);
            }
        }

        if(isset($filter['balkon'])) {
            $filter['terrasse'] = 1;
            $filter['loggia'] = 1;
        }

        if(isset($filter['objektart_id'][0]) && $filter['objektart_id'][0] == '') {
            unset($filter['objektart_id']);
        }

        /*
        if(isset($filter['objektart_id'][0]) && $filter['objektart_id'][0] == 6) {
            $filter['objektart_id'][] = 7;
            $filter['objektart_id'][] = 8;
            $filter['objektart_id'][] = 11;
        }
        */

        if((isset($filter['preis_von']))) {
            $filter['preis_von'] = intval($filter['preis_von']) ? intval($filter['preis_von']) : '';
        }
        if((isset($filter['preis_bis']))) {
            $filter['preis_bis'] = intval($filter['preis_bis']) ? intval($filter['preis_bis']) : '';
        }
        if((isset($filter['flaeche_von']))) {
            $filter['flaeche_von'] = intval($filter['flaeche_von']) ? intval($filter['flaeche_von']) : '';
        }
        if((isset($filter['flaeche_bis']))) {
            $filter['flaeche_bis'] = intval($filter['flaeche_bis']) ? intval($filter['flaeche_bis']) : '';
        }
        if((isset($filter['zimmer_von']))) {
            $filter['zimmer_von'] = intval($filter['zimmer_von']) ? intval($filter['zimmer_von']) : '';
        }
        if((isset($filter['zimmer_bis']))) {
            $filter['zimmer_bis'] = intval($filter['zimmer_bis']) ? intval($filter['zimmer_bis']) : '';
        }

        $obj_list = $this->ji_client->getList($params, $filter, $this->orderby, $this->max_per_page * ($this->page -1), $this->max_per_page, $this->ordertype);
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
