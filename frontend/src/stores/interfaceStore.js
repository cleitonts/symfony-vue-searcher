import { defineStore } from "pinia";
import { ref } from "vue";

export const useInterfaceStore = defineStore("interface", () => {
  const pageTitle = ref("");

  return {
    pageTitle,
  };
});
