import http from '@/api/http';

export async function fetchList(page, sort, direction, price_from, price_to, q, category, brand, tag){
	let data = await http.get('products', {
	  params: {
      page: page,
      sort: sort,
      direction: direction,
      filter: {
        brand: brand,
        tag: tag,
        price_from: price_from,
        price_to: price_to,
        q: q
      },
      category: category
    }
  });

	return data;
}
