import http from '@/api/http';

export async function login(username, password){
	let data = await http.post('login_check', { username, password }, {
		errorAlert: 'при попытке логина'
	});

	return data;
}

export async function check(){
	try{
		let { data } = await http.get('auth/check.php', {
			appSilence401: true
		});
		return data;
	}
	catch(e){
		return { res: false };
	}
}
