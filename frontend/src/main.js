import { createApp, markRaw } from "vue";
import { createPinia } from "pinia";
import axios from "axios";
import { setupInterceptorsTo } from "@/plugins/axios";
setupInterceptorsTo(axios);

import App from "./App.vue";
import router from "./router";

// Vuetify
import vuetify from "@/plugins/vuetify";

const app = createApp(App);
app.config.globalProperties.configVars = {
  $apiUrl: import.meta.env.VITE_API_URL,
  $http: markRaw(axios),
  $router: markRaw(router),
};
app.provide("configVars", app.config.globalProperties.configVars);

app.use(createPinia());
app.use(router);
app.use(vuetify);

app.mount("#app");
