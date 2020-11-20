<template>
  <fragment>
    <ContactSearch />
    <section class="contacts">
      <div class="contacts-title">
        <h2>Список контактов</h2>
        <button
          @click="addContact"
          type="button"
          class="button show-adding-modal"
        >
          Добавить
        </button>
      </div>

      <Loading v-show="this.$store.state.isLoading" />
      <fragment v-if="!this.$store.state.isLoading">
        <ul v-if="contacts.length" class="contacts-list">
          <ContactListItem
            v-for="contact in contacts"
            :key="contact.id"
            v-bind="contact"
            :editContact="() => editContact(contact)"
          />
        </ul>
        <p v-else>Ничего не найдено</p>

        <Paginator v-if="this.$store.getters.pagesCount > 1" />
      </fragment>
    </section>
  </fragment>
</template>

<script>
import Loading from "../Loading";
import ContactSearch from "./ContactSearch";
import ContactListItem from "./ContactListItem";
import Paginator from "./Paginator.vue";

export default {
  name: "ContactList",
  computed: {
    contacts() {
      return this.$store.state.contact.contacts;
    },
  },
  methods: {
    addContact() {
      this.$store.commit("showAddingModal");
    },
    editContact(contact) {
      this.$store.commit("showEditModal", { ...contact });
    },
  },
  components: {
    Loading,
    ContactSearch,
    ContactListItem,
    Paginator,
  },
  mounted() {
    this.$store.dispatch("loadContacts");
  },
};
</script>