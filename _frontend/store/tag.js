import { defineStore } from 'pinia';
import * as tagApi from '~/api/tag.js';

export const useTagStore = defineStore('tag', {
  state: () => ({
    tags: [],
  }),
  getters: {},
  actions: {
    async setTags(){
      let { res, data } = await tagApi.fetchList();

      if(res && data){
        this.tags = data;
      }
    },
  }
});
