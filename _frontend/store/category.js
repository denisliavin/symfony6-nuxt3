import { defineStore } from 'pinia';
import * as categoryApi from '~/api/category.js';

export const useCategoryStore = defineStore('category', {
  state: () => ({
    categories: [],
  }),
  getters: {},
  actions: {
    async setCategories(){
      let { res, data } = await categoryApi.fetchList();

      if(res && data){
        this.categories = data;
      }
    },
  }
});
