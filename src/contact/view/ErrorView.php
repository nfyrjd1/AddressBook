<p class="message">При обработке запроса возникли следующие ошибки:</p>
<ul class="errors-list">
    <?php
        foreach($errors as $error) {
            echo '<li class="error-item">'.$error.'</li>';
        }
    ?>
</ul>
<a href="<?php echo $redirect ?>" class="button error-button">Назад</a>