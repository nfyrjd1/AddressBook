<section class="modal hidden">
<div class="modal-dialog">
    <div class="modal-content modal-contact-adding">
        <div class="modal-header">
            <h2>Добавление нового контакта</h2>
            <button type="button" class="modal-close">&times;</button>
        </div>
        <form class="contact-form" method="POST" enctype="multipart/form-data">
            <input name="id" type="hidden" id="contact-id" value="0">
            <p>
                <label for="contact-name">ФИО контакта</label>
                <input maxlength="50" class="input" id="contact-name" name="name" type="text" required placeholder="Фамилия Имя Отчество">
            </p>
            <p>
                <label for="contact-phone">Номер телефона</label>
                <input class="input" id="contact-phone" pattern="\+\d{0,1}-\d{0,3}-\d{0,3}-\d{0,2}-\d{0,2}$" name="phone" type="tel" required placeholder="+7-123-456-78-90">
            </p>
            <p>
                <label for="contact-address">Адрес</label>
                <input maxlength="80" class="input" id="contact-address" name="address" type="text" placeholder="Город, ул. Улица 1">
            </p>
            <p>
                <label for="contact-email">Электронная почта</label>
                <input maxlength="30" class="input" type="email" pattern="^[\w\-.]+@[\w\-.]+\.[\w\-.]+$" id="contact-email" name="email" placeholder="example@gmail.com">
            </p>
            <p>
                <label for="contact-birthday">Дата рождения</label>
                <input class="input" id="contact-birthday" name="birthday" type="date">
            </p>
            <p>
                <label for="contact-image">Фотография</label>
                <label class="button image-picker">
                    <input accept="image/x-png,image/jpeg" class="hidden" id="contact-image" name="image" type="file">
                    <span>Выберите фотографию</span>
                </label>
            </p>
            <button class="button" type="submit">Сохранить</button>
        </form>
    </div>
</div>
</section>