//modal
const modal = document.querySelector('.modal'),
    showModal = document.querySelector('.show-adding-modal'),
    showEditModal = document.querySelectorAll('.contact-edit'),
    modalClose = document.querySelector('.modal-close');

const modalName = document.querySelector('#contact-name'),
    modalPhone = document.querySelector('#contact-phone'),
    modalAddress = document.querySelector('#contact-address'),
    modalEmail = document.querySelector('#contact-email'),
    modalBirthday = document.querySelector('#contact-birthday'),
    modalId = document.querySelector('#contact-id'),
    contactForm = document.querySelector('.contact-form'),
    contactFormButton = document.querySelector('.contact-form button'),
    modalTitle = document.querySelector('.modal-header h2');

const closeModal = () => {
    modal.classList.toggle('hidden');
    document.body.style.overflow = 'visible';

    filePickerText.innerText = defaultPickerText;
    modalTitle.innerText = defaultModalTitle;
    contactForm.reset();
}

const openModal = () => {
    modal.classList.toggle('hidden');
    document.body.style.overflow = 'hidden';
}

modalClose.addEventListener('click', () => {
    closeModal();
});

if (showModal) {
    showModal.addEventListener('click', () => {
        openModal();
        modalName.focus();
        modalId.value = 0;
    });
}

modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        closeModal();
    }
});

document.addEventListener('keydown', (e) => {
    if (e.code === 'Escape' && !modal.classList.contains('hidden')) {
        closeModal();
    }
});


//pick photo
const filePicker = document.querySelector('.image-picker input'),
    filePickerText = document.querySelector('.image-picker span');

const defaultPickerText = filePickerText.innerText;

filePicker.addEventListener('change', (e) => {
    if (e.target.value) {
        filePickerText.innerText = `Выбрано: ${e.target.value.replace(/^.*\\/,'')}`
    } else {
        filePickerText.innerText = defaultPickerText;
    }
});


//edit modal 
const defaultModalTitle = modalTitle.innerText;

showEditModal.forEach((btn) => {
    btn.addEventListener('click', () => {
        openModal();
        modalTitle.innerText = 'Редактирование контакта';
        const contact = btn.closest('.contact-container');

        const id = contact.id;
        const name = contact.querySelector('.contact-info-name').innerText;

        let phone = contact.querySelector('.contact-info-phone');
        if (phone) phone = phone.lastChild.textContent;

        let address = contact.querySelector('.contact-info-address');
        if (address) address = address.lastChild.textContent;

        let email = contact.querySelector('.contact-info-email');
        if (email) email = email.lastChild.textContent;

        let birthday = contact.querySelector('.contact-info-birthday');
        if (birthday) birthday = birthday.lastChild.textContent;

        modalId.value = id;
        modalName.value = name;
        modalPhone.value = phone;
        modalAddress.value = address;
        modalEmail.value = email;
        if (birthday) {
            modalBirthday.value = `${birthday.substr(0,4)}-${birthday.substr(5,2)}-${birthday.substr(8,2)}`;
        }
    });
});


//input
modalPhone.addEventListener('input', (e) => {
    const x = e.target.value.replace(/\D/g, '').match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
    e.target.value = !x[2] ? x[1] : `+${x[1]}-${x[2]}` + (x[3] ? `-${x[3]}` : '') + (x[4] ? `-${x[4]}` : '') + (x[5] ? `-${x[5]}` : '')
});
