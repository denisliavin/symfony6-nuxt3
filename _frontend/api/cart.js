import http from '@/api/http';

export async function add(product_id, featuresValues_ids, key){
  let data = await http.post('cart/add', {
    product_id: product_id,
    featuresValues_ids: featuresValues_ids,
    key: key
  });

  return data;
}
