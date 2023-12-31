<template>
  <TheMainAppBar />

  <v-main ref="mainView">
    <v-container ref="mainContainer" fluid>
      <router-view v-slot="{ Component, route }" name="default">
        <transition
          :key="route.path"
          :name="route.meta.transition"
          mode="out-in"
          :duration="300"
        >
          <suspense>
            <template #default>
              <component :is="Component" :key="route.path" />
            </template>
            <template #fallback>
              <the-spinner :height="containerHeight + 'px'"></the-spinner>
            </template>
          </suspense>
        </transition>
      </router-view>
      <suspense>
        <the-notifications />
      </suspense>
    </v-container>
  </v-main>
</template>

<script>
import TheMainAppBar from "@/components/TheMainAppBar.vue";
import TheNotifications from "./TheNotifications.vue";
import { defineComponent } from "vue";

export default defineComponent({
  name: "TheMainLayout",
  components: { TheMainAppBar, TheNotifications },
  data() {
    return {
      mainContainer: null,
      containerHeight: 0,
    };
  },
  mounted() {
    this.containerHeight =
      this.$refs.mainContainer.$vuetify.display.height - 152;
  },
});
</script>
