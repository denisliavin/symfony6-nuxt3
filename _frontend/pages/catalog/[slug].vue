<template>
    <ProductList></ProductList>
</template>
<script setup>
import { useProductStore } from '~/store/product';
const route = useRoute()
const productStore = useProductStore()
productStore.category = route.params.slug
</script>
