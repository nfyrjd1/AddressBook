<?php

class ImageModel{
    public static function saveImage($image, $id) {
        if (isset($image)) {
            $imageName = $id . $image['name'];
            move_uploaded_file($image['tmp_name'], IMAGES_PATH . $imageName);
            return $imageName;
        }

        return null;
    }
}