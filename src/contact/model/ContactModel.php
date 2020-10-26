<?php
include_once 'ContactModel.php';
include_once 'ImageModel.php';

class ContactModel
{

    public function __construct($id, $name, $phone, $address = null, $email = null, $birthday = null, $image = null)
    {
        $this->id = htmlspecialchars($id);
        $this->name = htmlspecialchars($name);
        $this->phone = htmlspecialchars($phone);

        $this->image = $image;
        $this->email = empty($email) ? null : htmlspecialchars($email);
        $this->address = empty($address) ? null : htmlspecialchars($address);
        $this->birthday = empty($birthday) ? null : htmlspecialchars($birthday);
    }

    public function isImageExist()
    {
        if (!isset($this->image)) return false;

        return file_exists(IMAGES_PATH . $this->image);
    }

    public static function setContact($contactArray)
    {
        if (!is_array($contactArray) || count($contactArray) < 3) return null;

        $id = $contactArray['Id_Contact'];
        $name = $contactArray['Name'];
        $phone = $contactArray['Phone'];
        $address = $contactArray['Address'];
        $email = $contactArray['Email'];
        $birthday = $contactArray['Birthday'];
        $image = $contactArray['Image'];

        $contact = new ContactModel($id, $name, $phone, $address, $email, $birthday, $image);
        return $contact;
    }

    public static function processContact($data)
    {
        $errors = [];

        if (isset($data['id']) && !empty($data['name']) && !empty($data['phone'])) {
            $id = htmlspecialchars($data['id']);
            $name = htmlspecialchars($data['name']);

            $phone = htmlspecialchars($data['phone']);
            if (empty($phone) && !preg_match('/\+\d{0,1}-\d{0,3}-\d{0,3}-\d{0,2}-\d{0,2}$/', $phone)) {
                array_push($errors, 'Номер телефона представлен в неверном формате!');
            }

            $email = htmlspecialchars($data['email']);
            if (!empty($email) && !preg_match('/^[\w\-.]+@[\w\-.]+\.[\w\-.]+$/', $email)) {
                array_push($errors, 'Адрес электронной почты представлен в неверном формате!');
            }

            $address = htmlspecialchars($data['address']);

            $birthday = htmlspecialchars($data['birthday']);
            if (!empty($birthday) && !checkdate((int)substr($birthday, 5, 2), (int)substr($birthday, 8, 2), (int)substr($birthday, 0, 4))) {
                array_push($errors, 'Дата рождения представлена в неверном формате!');
            }

            $image = null;
            if ($_FILES['image']['error'] != 4) {
                if (!@getimagesize($_FILES['image']['tmp_name'])) {
                    array_push($errors, 'Выбранный файл не является картинкой!');
                } else {
                    $image = $_FILES['image'];
                }
            }

            if (count($errors) == 0) {
                $contact = new ContactModel($id, $name, $phone, $address, $email, $birthday, $image);
                $sqlError = false;
                if ($id == 0) {
                    $sqlError = $contact->addContact();
                } else {
                    $sqlError = $contact->updateContact();
                }

                if (!$sqlError) {
                    array_push($errors, 'При добавлении/изменении записи возникла ошибка!');
                }
            }
        } else {
            array_push($errors, 'Не заполнены обязательные поля!');
        }

        if (count($errors) > 0) return $errors;
    }

    public function addContact()
    {
        try {
            $db = mysql::getContext();
            $query = 'Insert Into contact (Name, Phone, Address, Email, Birthday) Values(?, ?, ?, ?, ?);';
            $db->execute($query, ['sssss', &$this->name, &$this->phone, &$this->address, &$this->email, &$this->birthday]);

            $id = mysqli_insert_id($db->getMysql());
            $imageName = ImageModel::saveImage($this->image, $id);
            if (isset($imageName)) {
                $query = 'Update contact Set Image = ? Where Id_Contact = ?;';
                $db->execute($query, ['si', &$imageName, &$id]);
            }
            
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function updateContact()
    {
        try {
            $db = mysql::getContext();
            $query = 'Update contact Set Name = ?, Phone = ?, Address = ?, 
                Email = ?, Birthday = ?, Image = IFNULL(?, Image) Where Id_Contact = ?;';

            $this->image = ImageModel::saveImage($this->image, $this->id);

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
