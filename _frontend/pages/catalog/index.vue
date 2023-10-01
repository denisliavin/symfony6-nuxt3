<template>
    <ProductList></ProductList>
</template>

<script setup>
import { useProductStore } from '~/store/product';
const productStore = useProductStore()
productStore.category = ''
productStore.filter = {
    price_from: '',
    price_to: '',
    brand: null,
    tag: null,
    q: ''
}
</script>
