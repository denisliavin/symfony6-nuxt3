const LOCAL_ACCESS_NAME = 'auth_accessToken';
const LOCAL_REFRESH_NAME = 'auth_refreshToken';

function setToken(access){
  localStorage.setItem(LOCAL_ACCESS_NAME, access);
}

function setRefreshToken(access){
  localStorage.setItem(LOCAL_REFRESH_NAME, access);
}

function cleanTokensData(){
  localStorage.removeItem(LOCAL_ACCESS_NAME);
}

function getAccessToken(){
  return localStorage.getItem(LOCAL_ACCESS_NAME);
}

function getJWTPayload(token){
	return parseJWT(token).payload;
}

function parseJWT(token){
	let parts = token.split('.');

	return {
		header: parsePart(parts[0]),
		payload: parsePart(parts[1]),
		sign: parts[2]
	};
}

function parsePart(str){
	return JSON.parse(window.atob(str));
}

export { setToken, setRefreshToken, cleanTokensData, getJWTPayload, getAccessToken }
