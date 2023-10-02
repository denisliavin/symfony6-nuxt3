import { defineStore } from 'pinia';
import * as cartApi from '~/api/cart.js';
import {changeQuantity, fetchCartInfo, fetchItems, removeItem} from "../api/cart";

export const useCartStore = defineStore('cart', {
  state: () => ({
    count_items: 0,
    items: [],
  }),
  getters: {},
  actions: {
    async add(product_id, featuresValues_ids){
      const key = useCookie('key')
      let { res } = await cartApi.add(product_id, featuresValues_ids, key.value);

      if(res){
        this.setCountItems()
      }
    },
    async changeQuantity(item_id, quantity){
      const key = useCookie('key')
      let { res, data } = await cartApi.changeQuantity(item_id, quantity, key.value);

      if(res && data){
        this.setItems()
        this.setCountItems()
      }
    },
    async removeItem(item_id){
      const key = useCookie('key')
      let { res, data } = await cartApi.removeItem(item_id, key.value);

      if(res && data){
        this.setItems()
        this.setCountItems()
      }
    },
    async setCountItems(){
      const key = useCookie('key')
      let { res, data } = await cartApi.fetchCount(key.value);

      if(res) {
        this.count_items = data;
      }
    },
    async setItems(){
      const key = useCookie('key')
      let { res, data } = await cartApi.fetchItems(key.value);

      if(res && data){
        this.items = data;
      }
    },
    async setCartInfo(){
      const key = useCookie('key')
      let { res, data } = await cartApi.fetchCartInfo(key.value);

      if(res && data){
        //this.count_items = data;
      }
    },
  }
});
