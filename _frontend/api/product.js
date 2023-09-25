import http from '@/api/http';

export async function fetchList(page, sort, direction){
	let data = await http.get('products', {
	  params: {
      page: page,
      sort: sort,
      direction: direction,
      filter: {
        price_from: 0,
        price_to: 100,
        q: 'qqq'
      }
    }
  });

	return data;
}
