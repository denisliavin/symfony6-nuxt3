import http from '@/api/http';

export async function fetchList(){
  let data = await http.get('tags');

  return data;
}
