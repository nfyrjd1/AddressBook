<?php
/*
* Модель фильтра для списка контактов
*
* @property string search Поисковой запрос
* @property int pageNum Номер страницы
* @property int pageNSize Размер страницы
*/

namespace AddressBook\Contact\Model;

class FilterContactListModel
{
    private $search = null;
    private $pageNum = 1;
    private $pageSize = 10;

    /*
    * Конструктор класса с установкой аттрибутов
    * 
    * @param array data Массив $_GET
    *
    * @return void
    */
    public function __construct($data)
    {
        if (isset($data['search']) && !empty($data['search'])) {
            $this->search = $data['search'];
            $this->filterSearch();
        }

        if (isset($data['page']) && !empty($data['page'])) {
            $this->pageNum = (int)$data['page'];
        }

        if (isset($data['size']) && !empty($data['size'])) {
            $pageSize = (int)$data['size'];
            $this->pageSize = $pageSize > 0 ? $pageSize : $this->pageSize;
        }
    }

    /*
    * Геттер для search
    * 
    * @return string | null
    */
    public function getSearch()
    {
        return $this->search;
    }

    /*
    * Геттер для pageNum
    * 
    * @return int
    */
    public function getPage() : int
    {
        return $this->pageNum;
    }

    /*
    * Геттер для pageSize
    * 
    * @return int
    */
    public function getPageSize() : int
    {
        return $this->pageSize;
    }

    /*
    * Валидация search
    * 
    * @return void
    */
    private function filterSearch()
    {
        $quotes = array("\x27", "\x22", "\x60", "\t", "\n", "\r", "*", "%", "<", ">", "?", "!");
        $this->search = trim(strip_tags($this->search));
        $this->search = str_replace($quotes, '', $this->search);
    }
}
