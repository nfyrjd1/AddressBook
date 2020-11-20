<?php
/*
* Класс для работы с изображениями
*/

namespace AddressBook\Contact\Model;

class ImageModel
{
    /*
    * Сохранение изображения
    * 
    * @param array image файл изображения из $_FILES
    * @param int id идентификатор контакта

    * @return string | null
    */
    public static function saveImage(array $image, int $id)
    {
        if (isset($image)) {
            $imageName = $id . $image['name'];
            move_uploaded_file($image['tmp_name'], IMAGES_PATH . $imageName);
            return $imageName;
        }

        return null;
    }
}