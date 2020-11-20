<?php
/*
* Контроллер контакта
*/

namespace AddressBook\Contact\Controller;

use AddressBook\Contact\Model\ContactCardModel;
use AddressBook\Contact\Model\ContactModel;
use AddressBook\Contact\Controller\ErrorController;

class ContactController
{
    /*
    * Получение контакта
    * 
    * @param int id Идентификатор контакта
    *
    * @return string
    */
    public function getContact(int $id): string
    {
        $contactCardModel = new ContactCardModel();
        $contact = $contactCardModel->getContact($id);
        if (isset($contact)) {
            return json_encode($contact, JSON_UNESCAPED_UNICODE);
        } else {
            $error = new ErrorController();
            return $error->error404("Контакт не найден");
        }
    }

    /*
    * Установка изображения контакта
    * 
    * @param int id Идентификатор контакта
    *
    * @return string
    */
    public function setImage(int $id) : string
    {
        $contact = ContactModel::updateContactImage($id);
        //Проверка на масссив ошибок при изменении
        if (is_array($contact)) {
            $error = new ErrorController();
            return $error->error400($contact);
        } else {
            //Возвращает идентификатор изменённого контакта
            http_response_code(200);
            return json_encode([
                "contactId" => $contact
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    /*
    * Добавление/изменение контакта
    * 
    * @param array contactData Ассоциативный массив с контактом
    *
    * @return string
    */
    public function processContact(array $contactData): string
    {
        $contact = ContactModel::processContact($contactData);
        //Проверка на масссив ошибок при обработке
        if (is_array($contact)) {
            $error = new ErrorController();
            return $error->error400($contact);
        } else {
            //Возвращает идентификатор изменённого контакта
            http_response_code(200);
            return json_encode([
                "contactId" => $contact
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}
