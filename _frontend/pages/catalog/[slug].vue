<template>
    <ProductList></ProductList>
</template>
<script setup>
import { useProductStore } from '~/store/product';
const route = useRoute()
const productStore = useProductStore()
productStore.category = route.params.slug
productStore.filter = {
    price_from: '',
    price_to: '',
    brand: null,
    tag: null,
    q: ''
}
</script>
