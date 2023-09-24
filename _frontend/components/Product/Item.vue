<template>
    <div class="col-md-4">
        <div class="product-item">
            <div class="product-title">
                <a href="#">Product Name</a>
                <div class="ratting">
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                </div>
            </div>
            <div class="product-image">
                <a href="product-detail.html">
                    <img src="img/product-1.jpg" alt="Product Image">
                </a>
                <div class="product-action">
                    <a href="#"><i class="fa fa-cart-plus"></i></a>
                    <a href="#"><i class="fa fa-heart"></i></a>
                    <a href="#"><i class="fa fa-search"></i></a>
                </div>
            </div>
            <div class="product-price">
                <h3><span>$</span>99</h3>
                <a class="btn" href=""><i class="fa fa-shopping-cart"></i>Buy Now</a>
            </div>
        </div>
    </div>
</template>
<script setup>
const props = defineProps(['product'])

console.log(props.product)
</script>
