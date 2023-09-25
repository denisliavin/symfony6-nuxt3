import http from '@/api/http';

export async function fetchList(){
  let data = await http.get('brands');

  return data;
}
