import { defineStore } from 'pinia';
import * as productApi from '~/api/product.js';

export const useProductStore = defineStore('product', {
  state: () => ({
    products: [],
    pagination: {
      count: 0,
      total: 0,
      per_page: 0,
      page: 1,
      pages: 0,
    },
    filter: {
      price_from: '',
      price_to: '',
      q: ''
    },
    sort: {
      sort: '',
      direction: ''
    }
  }),
  getters: {},
  actions: {
    async setProducts(){
      let { res, data } = await productApi.fetchList(
        this.pagination.page,
        this.sort.sort,
        this.sort.direction
      );

      if(res && data){
        this.products = data.items;
        this.pagination = data.pagination;
      }
    },
  }
});
