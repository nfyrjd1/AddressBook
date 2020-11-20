<template>
  <section class="search">
    <h2 class="hidden">Поиск контактов</h2>
    <form class="search-form">
      <input
        class="input"
        type="text"
        name="search"
        placeholder="Фамилия, имя, отчество контакта"
        v-model="search"
      />
      <button @click="searchSubmit" class="button">Найти</button>
    </form>
  </section>
</template>

<script>
export default {
  name: 'ContactSearch',
  computed: {
    search: {
      get() {
        return this.$store.state.contact.search;
      },
      set(value) {
         this.$store.commit('setSearch', value);
      }
    }
  },
  methods: {
    searchSubmit(e) {
      e.preventDefault();
      this.$store.dispatch('setSearch');
    }
  }
}
</script>