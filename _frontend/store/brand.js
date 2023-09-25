import { defineStore } from 'pinia';
import * as brandApi from '~/api/brand.js';

export const useBrandStore = defineStore('brand', {
  state: () => ({
    brands: [],
  }),
  getters: {},
  actions: {
    async setBrands(){
      let { res, data } = await brandApi.fetchList();

      if(res && data){
        this.brands = data;
      }
    },
  }
});
