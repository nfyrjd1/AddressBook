<li class="contacts-item">
    <div class="contact-container" id="<?php echo $contact->id ?>">
        <img class="contact-image" src="userImages/<?php echo $contact->isImageExist() ? $contact->image : 'defaultPhoto.jpg' ?>">
        <div class="contact-info">
            <p class="contact-info-name">
                <a href="<?php echo 'index.php?view=card&id=' . $contact->id ?>"><?php echo $contact->name ?></a>
            </p>
            <div class="contact-info-additional">
                <p class="contact-info-phone"><span>Телефон:</span><strong><?php echo $contact->phone ?></strong></p>
                <?php echo empty($contact->address) ? '' : '<p class="contact-info-address"><span>Адрес:</span><strong>' . $contact->address . '</strong></p>' ?>
                <?php echo empty($contact->email) ? '' : '<p class="contact-info-email"><span>Почта:</span><strong>' . $contact->email . '</strong></p>' ?>
                <?php echo empty($contact->birthday) ? '' : '<p class="contact-info-birthday"><span>Дата рождения:</span><strong>' . $contact->birthday . '</strong></p>' ?>
            </div>
        </div>
        <button type="button" class="contact-edit button">Редактировать</button>
    </div>
</li>