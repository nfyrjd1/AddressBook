<?php
/*
* Модель контакта
*
* @property int id Идентификатор контакта
* @property string name ФИО 
* @property string phone Телефон 
* @property string address Адрес 
* @property string email Почта
* @property string birthday Дата рождения 
* @property string image Название файла изображения контакта
* @property string imageSrc Ссылка на изображение
*
*/

namespace AddressBook\Contact\Model;

use AddressBook\Core\Db\MySql;
use AddressBook\Contact\Model\ImageModel;
use Exception;

class ContactModel
{
    /*
    * Конструктор класса
    * 
    * @param int id Идентификатор контакта
    * @param string name ФИО 
    * @param string phone Телефон 
    * @param string address Адрес 
    * @param string email Почта
    * @param string birthday Дата рождения 
    * @param string image Название файла изображения контакта
    *
    * @return void
    */
    public function __construct(
        int $id,
        string $name,
        string $phone,
        string $address = null,
        string $email = null,
        string $birthday = null,
        string $image = null
    ) {
        $this->id = htmlspecialchars($id);
        $this->name = htmlspecialchars($name);
        $this->phone = htmlspecialchars($phone);

        $this->image = $image;
        $this->email = empty($email) ? null : htmlspecialchars($email);
        $this->address = empty($address) ? null : htmlspecialchars($address);
        $this->birthday = empty($birthday) ? null : htmlspecialchars($birthday);

        if ($this->isImageExist()) {
            $this->imageSrc = IMAGES_URL . $this->image;
        } else {
            $this->imageSrc = IMAGES_URL . 'defaultPhoto.jpg';
        }
    }

    /*
    * Проверка есть ли изображение
    *
    * @return bool
    */
    public function isImageExist()
    {
        if (!isset($this->image)) {
            return false;
        }

        return file_exists(IMAGES_PATH . $this->image);
    }

    /*
    * Создание объекта контакта
    * 
    * @param array | null contactArray Ассоциативный массив с контактом
    *
    * @return ContactModel | null
    */
    public static function setContact($contactArray)
    {
        if (!is_array($contactArray) || count($contactArray) < 3) {
            return null;
        }

        $id = (int)$contactArray['Id_Contact'];
        $name = $contactArray['Name'];
        $phone = $contactArray['Phone'];
        $address = $contactArray['Address'];
        $email = $contactArray['Email'];
        $birthday = $contactArray['Birthday'];
        $image = $contactArray['Image'];

        $contact = new ContactModel($id, $name, $phone, $address, $email, $birthday, $image);
        return $contact;
    }

    /*
    * Добавление/изменение контакта в бд
    * 
    * @param array contactData Ассоциативный массив с контактом
    *
    * @return id | array
    */
    public static function processContact(array $contactData)
    {
        $errors = [];

        if (isset($contactData['id']) && !empty($contactData['name']) && !empty($contactData['phone'])) {
            $id = htmlspecialchars($contactData['id']);
            $name = htmlspecialchars($contactData['name']);

            $phone = htmlspecialchars($contactData['phone']);
            if (empty($phone) && !preg_match('/^\+\d{1}-\d{3}-\d{3}-\d{2}-\d{2}$/', $phone)) {
                array_push($errors, 'Номер телефона представлен в неверном формате!');
            }

            $email = htmlspecialchars($contactData['email']);
            if (!empty($email) && !preg_match('/^[\w\-.]+@[\w\-.]+\.[\w\-.]+$/', $email)) {
                array_push($errors, 'Адрес электронной почты представлен в неверном формате!');
            }

            $address = htmlspecialchars($contactData['address']);

            $birthday = htmlspecialchars($contactData['birthday']);
            if (!empty($birthday) && !checkdate((int)substr($birthday, 5, 2), (int)substr($birthday, 8, 2), (int)substr($birthday, 0, 4))) {
                array_push($errors, 'Дата рождения представлена в неверном формате!');
            }

            if (count($errors) == 0) {
                $contact = new ContactModel($id, $name, $phone, $address, $email, $birthday);
                $sqlError = false;
                if ($id == 0) {
                    $sqlError = $contact->addContact();
                    $id = MySql::getInstance()->getLastInsertedID();
                } else {
                    $sqlError = $contact->updateContact();
                }

                if (!$sqlError) {
                    array_push($errors, 'При добавлении/изменении записи возникла ошибка!');
                } else {
                    return $id;
                }
            }
        } else {
            array_push($errors, 'Не заполнены обязательные поля!');
        }

        if (count($errors) > 0) {
            return $errors;
        }
    }

    /*
    * Добавление/изменение изображения контакта в бд
    * 
    * @param int id Идентификатор контакта
    *
    * @return id | array
    */
    public static function updateContactImage(int $id)
    {
        $errors = [];

        $image = null;
        //Файл не был загружен
        if ($_FILES['image']['error'] != 4) {
            //Проверка на картинку
            if (!@getimagesize($_FILES['image']['tmp_name'])) {
                array_push($errors, 'Выбранный файл не является картинкой!');
            } else {
                $image = $_FILES['image'];
            }
        }

        if (count($errors) > 0) return $errors;

        $imageModel = new ImageModel();
        $imageName = $imageModel->saveImage($image, $id);

        try {
            $db = MySql::getInstance();
            $query = 'Update contact Set Image = ? Where Id_Contact = ?;';
            $db->execute($query, ['si', &$imageName, &$id]);

            return $id;
        } catch (Exception $e) {
            return ['При сохранении картинки произошла ошибка!'];
        }
    }

    /*
    * Добавление контакта в бд
    *
    * @return bool
    */
    public function addContact(): bool
    {
        try {
            $db = MySql::getInstance();
            $query = 'Insert Into contact (Name, Phone, Address, Email, Birthday) Values(?, ?, ?, ?, ?);';
            $db->execute($query, ['sssss', &$this->name, &$this->phone, &$this->address, &$this->email, &$this->birthday]);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /*
    * Изменение контакта в бд
    *
    * @return bool
    */
    public function updateContact(): bool
    {
        try {
            $db = MySql::getInstance();
            $query = 'Update contact Set Name = ?, Phone = ?, Address = ?, 
                Email = ?, Birthday = ?, Image = IFNULL(?, Image) Where Id_Contact = ?;';

            $db->execute($query, [
                'ssssssi', &$this->name, &$this->phone, &$this->address,
                &$this->email, &$this->birthday, &$this->image, &$this->id
            ]);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
