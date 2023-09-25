<template>
    <div class="col-md-4">
        <div class="product-item">
            <div class="product-title">
                <a href="#">{{ props.product.name }}</a>
                <div class="ratting">
                    <i v-for="item in rating" class="fa fa-star"></i>
                </div>
            </div>
            <div class="product-image">
                <a href="product-detail.html">
                    <img :src="props.product.image_src" alt="Product Image">
                </a>
                <div class="product-action">
                    <a href="#"><i class="fa fa-cart-plus"></i></a>
                    <a href="#"><i class="fa fa-heart"></i></a>
                    <a href="#"><i class="fa fa-search"></i></a>
                </div>
            </div>
            <div class="product-price">
                <h3><span>$</span>{{ props.product.price }}</h3>
                <a class="btn" href=""><i class="fa fa-shopping-cart"></i>Buy Now</a>
            </div>
        </div>
    </div>
</template>
<script setup>
import { computed } from "vue";
const props = defineProps(['product'])

const rating = computed(() => {
    let arr = [];

    for (let i = 0; i < props.product.rating; i++) {
        arr.push(1)
    }
    return arr;
})

</script>
