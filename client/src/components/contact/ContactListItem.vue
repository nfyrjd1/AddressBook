<template>
  <li class="contacts-item">
    <div class="contact-container">
      <img class="contact-image" :src="imageSrc" />
      <div class="contact-info">
        <p class="contact-info-name">
          <router-link :to="'contacts/'+id">{{name}}</router-link>
        </p>
        <div class="contact-info-additional">
          <p class="contact-info-phone"><span>Телефон:</span>{{phone}}</p>
          <p v-if="address" class="contact-info-address"><span>Адрес:</span>{{address}}</p>
          <p v-if="email" class="contact-info-email"><span>Почта:</span>{{email}}</p>
          <p v-if="birthday" class="contact-info-birthday"><span>Дата рождения:</span>{{birthday}}</p>
        </div>
      </div>
      <button type="button" @click="editContact" class="contact-edit button">Редактировать</button>
    </div>
  </li>
</template>

<script>
export default {
  name: 'ContactListItem',
  props: {
    id: Number,
    name: String,
    phone: String,
    address: String,
    email: String,
    birthday: String,
    imageSrc: String,
    editContact: Function
  }
}
</script>