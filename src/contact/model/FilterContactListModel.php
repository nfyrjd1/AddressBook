<?php

class FilterContactListModel
{
    private $search = null;
    private $pageNum = 1;

    public function __construct($data)
    {
        if (isset($data['search']) && !empty($data['search']))
            $this->search = $data['search'];

        if (isset($data['page']) && !empty($data['page']))
            $this->pageNum = (int)$data['page'];
    }

    public function getSearch()
    {
        return $this->search;
    }

    public function getPage()
    {
        return $this->pageNum;
    }
}
