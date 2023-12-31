<template>
  <div
    class="bg-primary-gradient d-flex align-items-center flex-column flex-sm-row"
  >
    <v-col cols="12" sm="6" md="6" lg="4" class="text-sm-left text-center">
      <router-link
        :to="{ name: 'FOHome' }"
        class="text-h5 text-sm-h4 text-decoration-none text-white"
      >
        Store
      </router-link>
    </v-col>

    <v-col cols="12" sm="6" md="6" lg="4">
      <v-text-field
        v-model="searchValue"
        class="searchArea"
        hide-details
        prepend-icon="fa fa-search"
        variant="plain"
        placeholder="Search"
        @click:prepend="search(searchValue)"
        @update:model-value="prepareSearch"
      ></v-text-field>
    </v-col>
  </div>
</template>

<script>
import { useInterfaceStore } from "@/stores/interfaceStore";
import { useAuthStore } from "@/stores/authStore";
import { ref } from "vue";
import { useRoute, useRouter } from "vue-router";

export default {
  name: "TheMainAppBar",
  setup() {
    const router = useRouter();
    const route = useRoute();

    const authStore = useAuthStore();
    const switchMenu = useInterfaceStore().switchMenu;
    const searchValue = ref(route.params.search);

    return { switchMenu, authStore, searchValue, router };
  },
  methods: {
    prepareSearch: function () {
      const term = this.searchValue;
      setTimeout(() => {
        this.search(term);
      }, 2000);
    },
    search: function (value) {
      if (value !== this.searchValue) return;
      this.router.push({
        name: "results",
        params: { search: value },
      });
    },
  },
};
</script>

<style lang="sass">
@import "@/assets/template/variables/colors.scss"
.searchArea
  align-items: center

  & .v-input__prepend
    padding: 0 !important
  & input
    background: lighten($primary, 15%)
    border-radius: 3px
    padding: 10px
  & i
    color: $text-light
    opacity: 1 !important
.align-items-center
  align-items: center
</style>
