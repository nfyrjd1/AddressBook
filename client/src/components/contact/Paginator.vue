<template>
  <nav>
    <ul class="paginator-list">
      <li
        v-for="(item, index) in paginatorItems"
        :key="index"
        :class="'paginator-item' + (item.current ? ' paginator-item-current' : '')"
      >
        <a @click="() => setPage(item.page)">
          {{ item.title }}
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  name: "Paginator",
  computed: {
    paginatorItems() {
      const paginator = [];
      const pagesCount = this.$store.getters.pagesCount;
      const page = this.$store.state.contact.page;
      let i = page - 3;

      if (i >= 2)
        paginator.push({
          title: "Начало",
          page: 1,
        });

      if (i <= 0) i = 1;

      for (i; i < pagesCount && i <= page + 3; i++) {
        let current = false;
        if (i == page) current = true;

        paginator.push({
          title: i,
          page: i,
          current,
        });
      }

      if (page <= pagesCount) {
        paginator.push({
          title: "Последняя",
          page: pagesCount,
          current: page == pagesCount
        });
      }

      return paginator;
    },
  },
  methods: {
    setPage(page = 1) {
      this.$store.dispatch('setPage', page);
    },
  },
};
</script>