<?php
/*
* Модель карточки контакта
*/

namespace AddressBook\Contact\Model;

use AddressBook\Core\Db\MySql;
use AddressBook\Contact\Model\ContactModel;

class ContactCardModel
{
    /*
    * Получение контакта из бд
    * 
    * @param int id Идентификатор контакта
    *
    * @return ContactModel | null
    */
    public function getContact(int $id)
    {
        $db = mysql::getInstance();
        $query = 'Select Id_Contact, Name, Phone, Address, Email, Birthday, Image From contact Where Id_Contact = ?;';
        $db->execute($query, ['i', &$id]);
        $contact = $db->fetchResult();

        return ContactModel::setContact($contact);
    }
}
