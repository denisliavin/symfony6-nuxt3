import { defineStore } from 'pinia';
import * as cartApi from '~/api/cart.js';

export const useCartStore = defineStore('cart', {
  state: () => ({
    count_items: 0,
  }),
  getters: {},
  actions: {
    async add(product_id, featuresValues_ids){
      const key = useCookie('key')
      let { res, data } = await cartApi.add(product_id, featuresValues_ids, key.value);

      if(res && data){
        //this.categories = data;
      }
    },
  }
});
