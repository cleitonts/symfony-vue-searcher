import { createRouter, createWebHistory } from "vue-router";

import FOHomeView from "@/views/FO/HomeView.vue";
import Results from "@/views/FO/Results.vue";

import BOHomeView from "@/views/BO/HomeView.vue";

import TheEmptyLayout from "@/components/TheEmptyLayout.vue";
import TheFrontOfficeLayout from "@/components/TheFrontOfficeLayout.vue";
import TheMainLayout from "@/components/TheMainLayout.vue";

import { useAuthStore } from "@/stores/authStore.js";
import { useInterfaceStore } from "@/stores/interfaceStore.js";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  linkActiveClass: "active",
  routes: [
    {
      path: "/bo",
      meta: {
        middleware: { requiresAuth: true },
      },
      children: [
        {
          path: "home",
          component: TheMainLayout,
          children: [
            {
              path: "",
              name: "BOHome",
              component: BOHomeView,
              meta: {
                pageTitle: "Home",
              },
            },
          ],
        },
      ],
    },
    {
      path: "/auth",
      component: TheEmptyLayout,
      meta: {
        middleware: { requiresAuth: false },
      },
      children: [
        {
          path: "login",
          name: "login",
          component: FOHomeView,
          meta: {
            pageTitle: "Authentication",
          },
        },
      ],
    },
    {
      path: "/",
      component: TheFrontOfficeLayout,
      meta: {
        middleware: { requiresAuth: false },
      },
      children: [
        {
          path: "",
          name: "FOHome",
          component: FOHomeView,
          meta: {
            pageTitle: "Welcome",
          },
        },
        {
          path: "results/:search?",
          name: "results",
          component: Results,
          meta: {
            pageTitle: "Search results",
          },
        },
      ],
    },
    // catch all redirect to home page
    { path: "/:pathMatch(.*)*", redirect: "/" },
  ],
});

router.beforeEach(async (to, from, next) => {
  if (to.meta.middleware.requiresAuth && !useAuthStore().user) {
    next({ name: "login" });
  }
  next();
});

router.afterEach((to) => {
  const interfaceStore = useInterfaceStore();
  const pageTitle = to.meta.pageTitle || interfaceStore.pageTitle;
  document.title = `${pageTitle}`;
});

export default router;
