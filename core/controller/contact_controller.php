<?php
    $errors = [];

    if (isset($_POST['id']) && !empty($_POST['name']) && !empty($_POST['phone'])) {
        $id = htmlspecialchars($_POST['id']);
        $name = htmlspecialchars($_POST['name']);

        $phone = htmlspecialchars($_POST['phone']);
        if (empty($phone) && !preg_match('/\+\d{0,1}-\d{0,3}-\d{0,3}-\d{0,2}-\d{0,2}$/', $phone)) {
            array_push($errors, 'Номер телефона представлен в неверном формате!');
        }

        $email = htmlspecialchars($_POST['email']);
        if (!empty($email) && !preg_match('/^[\w\-.]+@[\w\-.]+\.[\w\-.]+$/', $email)) {
            array_push($errors, 'Адрес электронной почты представлен в неверном формате!');
        }

        $address = htmlspecialchars($_POST['address']);

        $birthday = htmlspecialchars($_POST['birthday']);
        if (!empty($birthday) && !checkdate((int)substr($birthday, 5, 2), (int)substr($birthday, 8, 2), (int)substr($birthday, 0, 4))) {
            array_push($errors, 'Дата рождения представлена в неверном формате!');
        }

        $image = null;
        if ($_FILES['image']['error'] != 4) {
            if (!@getimagesize($_FILES['image']['tmp_name'])) {
                array_push($errors, 'Выбранный файл не является картинкой!');
            }
            else {
                $image = $_FILES['image'];
            }
        }

        if (count($errors) == 0) {
            include($_SERVER['DOCUMENT_ROOT'].'/addressbook/core/model/contact.php');
            include($_SERVER['DOCUMENT_ROOT'].'/addressbook/core/model/db.php');
            $db = new DB();
            $contact = new Contact($id, $name, $phone, $address, $email, $birthday, $image);
    
            $sqlError = false;
            if ($id == 0) {
                $sqlError = $db->addContact($contact);
            }
            else {
                $sqlError = $db->updateContact($contact);
            }
    
            if (!$sqlError) {
                array_push($errors, 'При добавлении/изменении записи возникла ошибка!');
            }
        }
    }
    else {
        array_push($errors, 'Не заполнены обязательные поля!');
    }

    if (count($errors) > 0) {
        include($_SERVER['DOCUMENT_ROOT'].'/addressbook/core/view/error.php');
        ErrorView::displayErrors($errors);
    }
    else {
        $redicet = $_SERVER['HTTP_REFERER'];
        header ("Location: $redicet");
    }
?>