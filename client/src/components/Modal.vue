<template>
  <section class="modal">
    <div class="modal-dialog">
      <div class="modal-content modal-contact-adding">
        <div class="modal-header">
          <h2>{{ this.$store.state.modal.modalTitle }}</h2>
          <button @click="closeModal" type="button" class="modal-close">
            &times;
          </button>
        </div>
        <form class="contact-form">
          <div>
            <label for="contact-name">ФИО контакта</label>
            <input
              :class="'input' + ($v.name.$error ? ' input-error' : '')"
              v-model="name"
              id="contact-name"
              name="name"
              type="text"
              @blur="$v.name.$touch()"
              placeholder="Фамилия Имя Отчество"
            />
            <p
              v-if="!$v.name.required && $v.name.$dirty"
              class="input-error-message"
            >
              ФИО контакта обязательно для заполнения
            </p>
            <p
              v-if="!$v.name.maxLength && $v.name.$dirty"
              class="input-error-message"
            >
              ФИО контакта не должно быть больше 50 символов
            </p>
          </div>
          <div>
            <label for="contact-phone">Номер телефона</label>
            <input
              :class="'input' + ($v.phone.$error ? ' input-error' : '')"
              id="contact-phone"
              v-model="phone"
              name="phone"
              type="tel"
              @blur="$v.phone.$touch()"
              placeholder="+7-123-456-78-90"
            />
            <p
              v-if="!$v.phone.required && $v.phone.$dirty"
              class="input-error-message"
            >
              Номер телефона обязателен для заполнения
            </p>
            <p
              v-if="!$v.phone.phone && $v.phone.$dirty && $v.phone.required"
              class="input-error-message"
            >
              Номер телефона должен быть в формате +7-123-456-78-90
            </p>
          </div>
          <div>
            <label for="contact-address">Адрес</label>
            <input
              :class="'input' + ($v.address.$error ? ' input-error' : '')"
              v-model="address"
              id="contact-address"
              name="address"
              @blur="$v.address.$touch()"
              type="text"
              placeholder="Город, ул. Улица 1"
            />
            <p
              v-if="!$v.address.maxLength && $v.address.$dirty"
              class="input-error-message"
            >
              Адрес не должен быть больше 80 символов
            </p>
          </div>
          <div>
            <label for="contact-email">Электронная почта</label>
            <input
              :class="'input' + ($v.email.$error ? ' input-error' : '')"
              type="email"
              v-model="email"
              @blur="$v.email.$touch()"
              id="contact-email"
              name="email"
              placeholder="example@mail.com"
            />
            <p
              v-if="!$v.email.email && $v.email.$dirty"
              class="input-error-message"
            >
              Почта должна быть в формате example@mail.com
            </p>
          </div>
          <div>
            <label for="contact-birthday">Дата рождения</label>
            <input
              class="input"
              v-model="birthday"
              id="contact-birthday"
              name="birthday"
              type="date"
              @input="$v.birthday.$touch()"
            />
          </div>
          <div>
            <label for="contact-image">Фотография</label>
            <label class="button image-picker">
              <input
                accept="image/x-png,image/jpeg"
                class="hidden"
                id="contact-image"
                name="image"
                type="file"
                @change="imagePicked"
              />
              <span>{{ imageTitle ? imageTitle : "Выберите фотографию" }}</span>
            </label>
          </div>
          <button
            :disabled="anyError"
            class="button"
            @click="modalSubmit"
            type="submit"
          >
            Сохранить
          </button>
        </form>
      </div>
    </div>
  </section>
</template>

<script>
import { required, maxLength, email } from "vuelidate/lib/validators";

export default {
  name: "Modal",
  data() {
    return {
      contact: {
        id: 0,
        name: null,
        phone: null,
        address: null,
        email: null,
        birthday: null,
      },
      imageFile: null,
    };
  },
  computed: {
    phone: {
      get() {
        return this.contact.phone;
      },
      set(value) {
        const x = value
          .replace(/\D/g, "")
          .match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
        this.contact.phone = null;
        this.contact.phone = !x[2]
          ? x[1]
          : `+${x[1]}-${x[2]}` +
            (x[3] ? `-${x[3]}` : "") +
            (x[4] ? `-${x[4]}` : "") +
            (x[5] ? `-${x[5]}` : "");
      },
    },
    name: {
      get() {
        return this.contact.name;
      },
      set(value) {
        this.contact.name = value;
      },
    },
    address: {
      get() {
        return this.contact.address;
      },
      set(value) {
        this.contact.address = value;
      },
    },
    birthday: {
      get() {
        return this.contact.birthday;
      },
      set(value) {
        this.contact.birthday = value;
      },
    },
    email: {
      get() {
        return this.contact.email;
      },
      set(value) {
        this.contact.email = value;
      },
    },

    anyError() {
      const anyError = this.$v.$anyError || !this.$v.$anyDirty;
      if (this.contact.id == 0) {
        return anyError;
      }

      if (this.imageFile || anyError) {
        return anyError;
      }
      return false;
    },
    imageTitle() {
      if (this.imageFile) {
        return this.imageFile.name;
      }

      return null;
    },
  },
  methods: {
    closeModal() {
      console.log("1");
      this.$store.commit("hideModal");
    },

    async modalSubmit(e) {
      e.preventDefault();
      if (this.$v.$anyError) {
        return;
      }

      const errors = this.$store.state.modal.postErrors;

      await this.$store.dispatch("postContact", this.contact);

      if (errors.length == 0 && this.imageFile) {
        const formData = new FormData();
        formData.append("id", this.$store.state.modal.contact.id);
        formData.append("image", this.imageFile);
        await this.$store.dispatch("postContactImage", formData);
      }

      if (errors.length == 0) {
        this.$store.dispatch(
          "updateContact",
          this.$store.state.modal.contact.id
        );
      }

      this.$store.commit("hideModal");
    },

    imagePicked(e) {
      const file = e.target.files[0];
      if (file) {
        this.imageFile = file;
        this.$v.$touch();
      }
    },
  },
  mounted() {
    const contact = this.$store.state.modal.contact;
    if (contact) {
      this.contact = contact;
    }

    window.addEventListener("keyup", e => {
      if (e.keyCode === 27) {
        this.closeModal();
      }
    });
  },
  validations: {
    name: {
      required,
      maxLength: maxLength(50),
    },
    phone: {
      required,
      phone(phone) {
        if (phone && phone.match(/^\+\d{1}-\d{3}-\d{3}-\d{2}-\d{2}$/)) {
          return true;
        }
        return false;
      },
    },
    email: {
      maxLength: maxLength(30),
      email,
    },
    address: {
      maxLength: maxLength(80),
    },
    birthday: {
      minValue: (value) => {
        if (value) {
          return value > new Date(1900, 0, 1).toISOString();
        }
        return true;
      },
    },
  },
};
</script>