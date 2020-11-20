<?php
/*
* Контроллер списка контактов
*/

namespace AddressBook\Contact\Controller;

use AddressBook\Contact\Model\ContactListModel;
use AddressBook\Contact\Model\FilterContactListModel;

class ContactListController
{
    /*
    * Получение списка контактов
    * @return string
    */
    public function getContacts(): string
    {
        //Получение фильтра списка
        $filter = new FilterContactListModel($_GET);

        $contactsModel = new ContactListModel();
        $contacts = $contactsModel->getContacts($filter);
        $contactsCount = $contactsModel->getContactsCount($filter);

        $response = [
            'pageNumber' => $filter->getPage(),
            'pageSize' => $filter->getPageSize(),
            'contacts' => $contacts,
            'contactsCount' => $contactsCount
        ];

        http_response_code(200);
        return json_encode($response, JSON_UNESCAPED_UNICODE);
    }
}
