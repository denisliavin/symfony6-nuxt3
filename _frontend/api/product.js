import http from '@/api/http';

export async function fetchList(){
	let data = await http.get('products', {
	  params: {
      sort: 'id',
      direction: 'desc',
      filter: {
        price_from: 0,
        price_to: 100,
        q: 'qqq'
      }
    }
  });

	return data;
}
