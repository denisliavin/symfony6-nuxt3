<template>
    <ProductList></ProductList>
</template>

<script setup>
import { useProductStore } from '~/store/product';
const productStore = useProductStore()
productStore.category = ''
</script>
