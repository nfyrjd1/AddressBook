<template>
  <fragment>
    <header>
      <button v-if="this.$route.name != 'contacts'" @click="routeBack" class="button header-back-button">Назад</button>
      <h1 class="page-title">
        <router-link to="/">Адресная книга</router-link>
      </h1>
    </header>
    <main class="container">
      <router-view></router-view>
      <Modal v-if="this.$store.state.modal.showModal" />
      <Error v-if="this.$store.state.modal.postErrors.length > 0" />
    </main>
  </fragment>
</template>

<script>
import Error from "./error/Error";
import Modal from "./Modal";

export default {
  name: "Layout",
  components: {
    Error,
    Modal,
  },
  methods: {
    routeBack() {
      if (this.$route.name == '404') {
        this.$router.go(-2);
        return;
      } 
      this.$router.go(-1);
    }
  },
  computed: {
    isModalOpen() {
      return this.$store.state.modal.showModal;
    }
  },
  watch: {
    isModalOpen() {
      if (this.isModalOpen) {
        document.body.style.overflow = 'hidden';
      } else {
        document.body.style.overflow = 'visible';
      }
    }
  }
};
</script>