<template>
  <section class="contact-page">
    <Loading v-show="this.$store.state.isLoading" />
    <div v-if="!this.$store.state.isLoading" class="contact-container">
      <img class="contact-page-image" :src="contact.imageSrc" :alt="contact.name" />
      <div class="contact-info">
        <p class="contact-page-name contact-info-name">{{ contact.name }}</p>
        <div class="contact-info-additional contact-page-additional">
          <p class="contact-info-phone"><span>Телефон:</span>{{ contact.phone }}</p>
          <p v-if="contact.address" class="contact-info-address">
            <span>Адрес:</span>{{ contact.address }}
          </p>
          <p v-if="contact.email" class="contact-info-email">
            <span>Почта:</span>{{ contact.email }}
          </p>
          <p v-if="contact.birthday" class="contact-info-birthday">
            <span>Дата рождения:</span>{{ contact.birthday }}
          </p>
        </div>
      </div>
      <button type="button" class="contact-edit button">Редактировать</button>
    </div>
  </section>
</template>

<script>
import Loading from "../Loading";

export default {
  name: "ContactCard",
  data() {
    return {
      id: this.$route.params["id"],
      contact: {
        name: null,
        phone: null,
        address: null,
        email: null,
        birthday: null,
        imageSrc: null
      }
    };
  },
  watch: {
    $route(toR) {
      this.id = toR.params["id"];
    },
  },
  components: {
    Loading,
  },
  async mounted() {
    const contact = await this.$store.dispatch('loadContact', this.id);
    if (contact) {
      this.contact = contact;
    } else {
      this.$router.push({path: '/404'});
    }
  },
};
</script>