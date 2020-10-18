<?php include($_SERVER['DOCUMENT_ROOT'].'/addressbook/core/view/header.php') ?>

        <?php 
            if ($_POST) {
                include($_SERVER['DOCUMENT_ROOT'].'/addressbook/core/controller/contact_controller.php');
            }
            else {
                include($_SERVER['DOCUMENT_ROOT'].'/addressbook/core/model/db.php');

                if (isset($_GET['id'])) {
                $id = (int)$_GET['id'];

                $db = new DB();
                $contact = $db->getContact($id);
                    if (!empty($contact->id)) {
                        ?>
                        <section class="contact-page">
                            <div class="contact-container" id="<?php echo $contact->id?>">
                                <img class="contact-page-image" src="./../../userImages/<?php echo $contact->isImageExist() ? $contact->image : 'defaultPhoto.jpg' ?>">
                                <div class="contact-info"> 
                                    <p class="contact-page-name contact-info-name"><?php echo $contact->name?></p>
                                    <div class="contact-info-additional contact-page-additional">
                                        <p class="contact-info-phone"><span>Телефон:</span><?php echo $contact->phone?></p>
                                        <?php echo empty($contact->address) ? '' : '<p class="contact-info-address"><span>Адрес:</span>'.$contact->address.'</p>'?>
                                        <?php echo empty($contact->email) ? '' : '<p class="contact-info-email"><span>Почта:</span>'.$contact->email.'</p>'?>
                                        <?php echo empty($contact->birthday) ? '' : '<p class="contact-info-birthday"><span>Дата рождения:</span>'.$contact->birthday.'</p>'?>
                                    </div>
                                </div>
                                <button type="button" class="contact-edit button">Редактировать</button>
                            </div>
                        </section>
                        <?php
                    }
                    else {
                        echo '<p>Контакт не найден</p>';
                    }
                } 
                else {
                    echo '<p>Контакт не найден</p>';
                }
            }
        ?>

    <?php include($_SERVER['DOCUMENT_ROOT'].'/addressbook/core/view/footer.php') ?>