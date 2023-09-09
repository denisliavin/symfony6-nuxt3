import { setRefreshToken, setToken, getJWTPayload, getAccessToken } from '@/utils/tokens';
import { defineStore } from 'pinia';
import * as authApi from '~/api/auth.js';

let readyRelosver;
let readyPromise = new Promise(function(resolve){
  readyRelosver = resolve;
});

export const useUserStore = defineStore('user', {
  state: () => ({
    authenticated: false,
    user: null,
  }),
  getters: {
    ready: state => readyPromise,
    isLogin: state => state.user !== null,
    //checkRole: state => allowedRoles => state.user !== null && allowedRoles.some(role => state.user.roles.includes(role))
  },
  mutations: {
    setUser(state, user){
      state.user = user;
    }
  },
  actions: {
    async autoLogin({ commit }){
      let { res, user } = await authApi.check();

      if(res){
        commit('setUser', user);
      }

      readyRelosver();
    },
    async login({ username, password }){
      let data = await authApi.login(username, password);

      if(!data){
        return { errors: 'Нет связи' }
      }
      else if(data.res){
        const token = useCookie('token'); // useCookie new hook in nuxt 3
        token.value = data.data.token; // set token to cookie
        const refresh_token = useCookie('refresh_token'); // useCookie new hook in nuxt 3
        refresh_token.value = data.data.refresh_token; // set token to cookie

        this.authenticated = true;
        //commit('setUser', { login, name, roles });
      }

      return data;
    },
    clean({ commit }){
      commit('setUser', null);
    }
  }
});
