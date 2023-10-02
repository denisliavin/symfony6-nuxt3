<template>
<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Products</a></li>
            <li class="breadcrumb-item active">Cart</li>
        </ul>
    </div>
</div>
<!-- Breadcrumb End -->

<!-- Cart Start -->
<div class="cart-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="cart-page-inner">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                <tr v-for="item in cartStore.items">
                                    <td>
                                        <div class="img">
                                            <a :href="'/product' + item.slug"><img :src="item.image_src" alt="Image"></a>
                                            <p>{{ item.name }}</p>
                                        </div>
                                    </td>
                                    <td>${{ item.price }}</td>
                                    <td>
                                        <div class="qty">
                                            <button @click.prevent="changeQuantity(item.id, item.quantity - 1)" class="btn-minus"><i class="fa fa-minus"></i></button>
                                            <input @input="changeQuantity(item.id, $event.target.value)" type="text" :value="item.quantity">
                                            <button @click.prevent="changeQuantity(item.id, item.quantity + 1)" class="btn-plus"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </td>
                                    <td>${{ item.price * item.quantity }}</td>
                                    <td>
                                        <button @click.prevent="remove(item.id)"><i class="fa fa-trash"></i></button></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cart-page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="coupon">
                                <input type="text" placeholder="Coupon Code">
                                <button>Apply Code</button>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="cart-summary">
                                <div class="cart-content">
                                    <h1>Cart Summary</h1>
                                    <p>Sub Total<span>$99</span></p>
                                    <p>Discount<span>$1</span></p>
                                    <h2>Grand Total<span>$100</span></h2>
                                </div>
                                <div class="cart-btn">
                                    <button>Update Cart</button>
                                    <button>Checkout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart End -->

</template>
<script setup>
import { onMounted } from "vue";
import { useCartStore } from '~/store/cart';
const cartStore = useCartStore()

onMounted(() => {
    cartStore.setItems()
})

const changeQuantity = (item_id, quantity) => {
    quantity = quantity > 1 ? quantity : 1
    cartStore.changeQuantity(item_id, quantity)
};

const remove = (item_id) => {
    cartStore.removeItem(item_id)
};
</script>
