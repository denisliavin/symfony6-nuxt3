import { defineStore } from 'pinia';
import * as productApi from '~/api/product.js';

export const useProductStore = defineStore('product', {
  state: () => ({
    tag: null,
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
      category: null,
      brand: null,
      tag: null,
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
        this.sort.direction,
        this.filter.price_from,
        this.filter.price_to,
        this.filter.q,
        this.category,
        this.filter.brand,
        this.filter.tag
      );

      if(res && data){
        this.products = data.items;
        this.pagination = data.pagination;
      }
    },
  }
});
