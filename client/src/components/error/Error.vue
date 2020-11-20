<template>
  <section class="modal">
    <div class="modal-dialog-error">
      <div class="modal-content">
        <div class="modal-header">
          <h2>При обработке запроса возникли следующие ошибки:</h2>
          <button @click="clearErrors" type="button" class="modal-close">
            &times;
          </button>
        </div>
        <ul class="errors-list">
          <li
            class="error-item"
            v-for="(error, index) in this.$store.state.modal.postErrors"
            :key="index"
          >
            {{ error }}
          </li>
        </ul>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'Error',
  methods: {
    clearErrors() {
      this.$store.commit('clearErrors');
    },
  },
  beforeDestroy() {
    this.clearErrors();
  },
};
</script>