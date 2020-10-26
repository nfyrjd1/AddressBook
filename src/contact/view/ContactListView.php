<section class="contacts">
    <div class="contacts-title">
        <h2>Список контактов</h2>
        <button type="button" class="button show-adding-modal">Добавить</button>
    </div>

    <?php
    if (!empty($contacts)) {
        echo '<ul class="contacts-list">';
        echo $contacts;
        echo '</ul>';
    } else {
        echo '<p>Ничего не найдено</p>';
    }
    ?>

</section>