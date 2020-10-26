$(document).ready(() => {
    //modal
    const modal = $('.modal');

    const modalName = $('#contact-name'),
        modalPhone = $('#contact-phone'),
        modalAddress = $('#contact-address'),
        modalEmail = $('#contact-email'),
        modalBirthday = $('#contact-birthday'),
        modalId = $('#contact-id'),
        contactForm = $('.contact-form'),
        modalTitle = $('.modal-header h2');

    const closeModal = () => {
        modal.toggleClass('hidden');
        document.body.style.overflow = 'visible';

        filePickerText.text(defaultPickerText);
        modalTitle.text(defaultModalTitle);
        contactForm.trigger("reset");
    }

    const openModal = () => {
        modal.toggleClass('hidden');
        document.body.style.overflow = 'hidden';
    }

    $('.modal-close').click(closeModal);

    $('.show-adding-modal').click(() => {
        openModal();
        modalName.focus();
        modalId.value = 0;
    });

    $(document).keyup(function (e) {
        if (e.code === 'Escape' && !modal.hasClass('hidden')) {
            closeModal();
        }
    });


    //pick photo
    const filePicker = $('.image-picker input'),
        filePickerText = $('.image-picker span');

    const defaultPickerText = filePickerText.text();

    filePicker.change(function () {
        if ($(this).val()) {
            filePickerText.text(`Выбрано: ${$(this).val().replace(/^.*\\/,'')}`);
        } else {
            filePickerText.text(defaultPickerText);
        }
    });

    //edit modal 
    const defaultModalTitle = modalTitle.text();
    $('.contact-edit').click(function () {
        openModal();
        modalTitle.text('Редактирование контакта');
        const contact = $(this).closest('.contact-container');
        const id = contact.id;

        let name = contact.find('.contact-info-name');
        if (name.children().length > 0) name = name.children().text();
        else name = name.text();

        let phone = contact.find('.contact-info-phone strong');
        if (phone) phone = phone.text();

        let address = contact.find('.contact-info-address strong');
        if (address) address = address.text();

        let email = contact.find('.contact-info-email strong');
        if (email) email = email.text();

        let birthday = contact.find('.contact-info-birthday strong');
        if (birthday) birthday = birthday.text();

        modalId.val(id);
        modalName.val(name);
        modalPhone.val(phone);
        modalAddress.val(address);
        modalEmail.val(email);
        if (birthday) {
            modalBirthday.val(`${birthday.substr(0,4)}-${birthday.substr(5,2)}-${birthday.substr(8,2)}`);
        }
    });


    //input
    modalPhone.on("input", function () {
        const x = $(this).val().replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
        $(this).val(!x[2] ? x[1] : `+${x[1]}-${x[2]}` + (x[3] ? `-${x[3]}` : '') + (x[4] ? `-${x[4]}` : '') + (x[5] ? `-${x[5]}` : ''));
    });
});