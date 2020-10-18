<?php
class ErrorView
{
    public static function displayErrors($errors)
    {
        echo '<p class="message">При обработке запроса возникли следующие ошибки:</p>';
        echo '<ul class="errors-list">';

        foreach($errors as $error) {
            echo '<li class="error-item">'.$error.'</li>';
        }

        echo '</ul>';

        echo '<a href="'.$_SERVER['HTTP_REFERER'].'" class="button error-button">Назад</a>';
    }
}

?>
