import { defineStore } from 'pinia';
import * as productApi from '~/api/product.js';

export const useProductStore = defineStore('product', {
  state: () => ({
    products: [],
  }),
  getters: {},
  actions: {
    async setProducts(){
      let { res, data } = await productApi.fetchList();

      if(res && data){
        this.products = data;
      }
    },
  }
});
