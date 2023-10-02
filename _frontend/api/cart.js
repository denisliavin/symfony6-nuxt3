import http from '@/api/http';

export async function add(product_id, featuresValues_ids, key){
  let data = await http.post('cart/add', {
    product_id: product_id,
    featuresValues_ids: featuresValues_ids,
    key: key
  });

  return data;
}

export async function changeQuantity(item_id, quantity, key){
  let data = await http.post('cart/set', {
    item_id: item_id,
    quantity: quantity,
    key: key
  });

  return data;
}

export async function removeItem(item_id, key){
  let data = await http.post('cart/remove', {
    item_id: item_id,
    key: key
  });

  return data;
}

export async function fetchCount(key){
  let data = await http.get('cart/count', {
      params: {
        key: key
      }
    });

  return data;
}

export async function fetchItems(key){
  let data = await http.get('cart/items', {
      params: {
        key: key
      }
    });

  return data;
}

export async function fetchCartInfo(key){
  let data = await http.get('cart/info', {
      params: {
        key: key
      }
    });

  return data;
}
