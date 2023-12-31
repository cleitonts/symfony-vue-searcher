import { defineStore } from "pinia";
import { inject, ref } from "vue";

export const useProductStore = defineStore("product", () => {
  const configVars = inject("configVars");

  const STATE = {
    productsList: ref([]),
    categoriesList: ref([]),
    brandsList: ref([]),
  };

  const ACTIONS = {
    getCategories: async function () {
      if (STATE.categoriesList.value.length) {
        return;
      }
      const returned = await configVars.$http.get(
        `${configVars.$apiUrl}/api/category`
      );
      STATE.categoriesList.value = { ...returned.data.data };
    },
    getBrands: async function () {
      if (STATE.brandsList.value.length) {
        return;
      }
      const returned = await configVars.$http.get(
        `${configVars.$apiUrl}/api/product/brands`
      );
      STATE.brandsList.value = { ...returned.data.data };
    },
    getProducts: async function (params) {
      const returned = await configVars.$http.get(
        `${configVars.$apiUrl}/api/product`,
        { params: params }
      );
      STATE.productsList.value = { ...returned.data.data };
    },
  };

  return { ...STATE, ...ACTIONS };
});
