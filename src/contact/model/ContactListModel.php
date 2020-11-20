<?php
/*
* Модель списка контактов
*/

namespace AddressBook\Contact\Model;

use AddressBook\Contact\Model\ContactModel;
use AddressBook\Contact\Model\FilterContactListModel;
use AddressBook\Core\Db\MySql;

class ContactListModel
{
    /*
    * Получение списка контактов
    *
    * @param FilterContactListModel filter Фильтр списка
    * 
    * @return array
    */
    public function getContacts(FilterContactListModel $filter = null): array
    {
        if (isset($filter)) {
            $pageSize = $filter->getPageSize();
            $pageNum = $filter->getPage() > 0 ? ($filter->getPage() - 1) * $pageSize : 0;
            $search = $filter->getSearch();
        }

        $db = MySql::getInstance();
        $query = 'Select Id_Contact, Name, Phone, Address, Email, Birthday, Image From contact Where Lower(Name) Like Lower(IFNULL(?, Name)) Limit ?,?;';
        if (isset($search)) {
            $search = "%$search%";
        }

        $db->execute($query, ['sii', &$search, &$pageNum, &$pageSize]);
        $contacts = [];
        while ($contact = $db->fetchResult()) {
            array_push($contacts, ContactModel::setContact($contact));
        }
        return $contacts;
    }

    /*
    * Получение количества контактов
    *
    * @param FilterContactListModel filter Фильтр списка
    * 
    * @return int
    */
    public function getContactsCount(FilterContactListModel $filter = null): int
    {
        if (isset($filter)) {
            $search = $filter->getSearch();
        }

        $db = MySql::getInstance();
        $query = 'Select Count(Id_Contact) ContactsCount From contact Where Lower(Name) Like Lower(IFNULL(?, Name));';
        if (isset($search)) {
            $search = "%$search%";
        }

        $db->execute($query, ['s', &$search]);
        $count = $db->fetchResult();
        return $count['ContactsCount'];
    }
}
