import axios from 'axios';
import { getAccessToken, cleanTokensData } from '@/utils/tokens';

const baseURL = 'http://nginx/api/';
const instance = axios.create({
  baseURL,
  timeout: 10000,
  withCredentials: false
});

instance.interceptors.request.use(addAccessToken);

instance.interceptors.response.use(
	async response => {
    response['res'] = true

    return response
  },
	async error => {
		if(error.response.status !== 401){
			return Promise.reject(error); // ошибка, не связанная с авторизацией
		}

		cleanTokensData();
		let response = await instance.get('auth/refresh/refresh.php');

		if(!response.data.res){
			return Promise.reject(error); // прокидываем 401 код дальше
		}

		//setTokens(response.data.accessToken);
		return axios(addAccessToken(error.config));
	}
);

export function addResponseHandler(success, error){
	instance.interceptors.response.use(success, error);
}

export default instance;

function addAccessToken(request){
	let token = getAccessToken();

	if(token !== null){
		request.headers.Authorization = `Bearer ${token}`;
	}

	return request;
}
