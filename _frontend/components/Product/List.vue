<template>
        <!-- Breadcrumb Start -->
        <div class="breadcrumb-wrap">
            <div class="container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Products</a></li>
                    <li class="breadcrumb-item active">Product List</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->

        <!-- Product List Start -->
        <div class="product-view">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="product-view-top">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="product-search">
                                                <input @input="changeSearch($event.target.value)" type="email" placeholder="Search">
                                                <button><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="product-short">
                                                <div class="dropdown">
                                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                                        <template v-if="productStore.sort.sort == 'id'">Newest</template>
                                                        <template v-else-if="productStore.sort.sort == 'rating'">Popular</template>
                                                        <template v-else-if="productStore.sort.sort == 'price_new'">Most sale</template>
                                                        <template v-else>Product short by</template>
                                                    </div>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a @click.prevent="changeSort('id', 'desc')" :class="productStore.sort.sort == 'id' ? 'disabled' : ''" href="#" class="dropdown-item">Newest</a>
                                                        <a @click.prevent="changeSort('rating', 'desc')" :class="productStore.sort.sort == 'rating' ? 'disabled' : ''" href="#" class="dropdown-item">Popular</a>
                                                        <a @click.prevent="changeSort('price_new', 'asc')" :class="productStore.sort.sort == 'price_new' ? 'disabled' : ''" href="#" class="dropdown-item">Most sale</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="product-price-range">
                                                <div class="dropdown">
                                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                                        <template v-if="productStore.filter.price_from && productStore.filter.price_to">
                                                            <template v-for="item in pricesRange">
                                                                <template v-if="productStore.filter.price_from == item.from && productStore.filter.price_to == item.to">${{ item.from }} to ${{ item.to }}</template>
                                                            </template>
                                                        </template>
                                                        <template v-else>
                                                            Product price range
                                                        </template>
                                                    </div>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <template v-for="item in pricesRange">
                                                            <a @click.prevent="changePriceRange(item.from, item.to)" href="#" :class="productStore.filter.price_from == item.from && productStore.filter.price_to == item.to ? 'disabled' : ''" class="dropdown-item">${{ item.from }} to ${{ item.to }}</a>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <template v-for="product in productStore.products">
                                <ProductItem :product="product"></ProductItem>
                            </template>
                        </div>

                        <!-- Pagination Start -->
                        <div class="col-md-12">

                            <nav aria-label="Page navigation example">
                                <vue-awesome-paginate
                                    v-if="productStore.pagination.total && productStore.pagination.per_page"
                                    :total-items="productStore.pagination.total"
                                    :items-per-page="productStore.pagination.per_page"
                                    :max-pages-shown="5"
                                    v-model="productStore.pagination.page"
                                    :on-click="onClickPagination"
                                    pagination-container-class="pagination justify-content-center"
                                    paginate-buttons-class="page-link"
                                    active-page-class="active"
                                    next-button-content="Next"
                                    prev-button-content="Previous"
                                />
                            </nav>
                        </div>
                        <!-- Pagination Start -->
                    </div>

                    <!-- Side Bar Start -->
                    <div class="col-lg-4 sidebar">
                        <div class="sidebar-widget category">
                            <h2 class="title">Category</h2>
                            <nav class="navbar bg-light">
                                <ul class="navbar-nav">
                                    <li v-for="category in categoryStore.categories" class="nav-item">
                                        <NuxtLink :to="'/catalog/' + category.slug" :class="category.slug == productStore.category ? 'disabled' : ''" class="nav-link">
                                            <i :class="category.icon"></i>{{ category.name }}
                                        </NuxtLink>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        <div class="sidebar-widget widget-slider">
                            <div class="sidebar-slider normal-slider">
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
                                            <img src="img/product-10.jpg" alt="Product Image">
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
                                            <img src="img/product-9.jpg" alt="Product Image">
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
                                            <img src="img/product-8.jpg" alt="Product Image">
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
                        </div>

                        <div class="sidebar-widget brands">
                            <h2 class="title">Our Brands</h2>
                            <ul>
                                <li v-for="brand in brandStore.brands">
                                    <a @click.prevent="changeBrand(brand.id)" :class="brand.id == productStore.filter.brand ? 'disabled' : ''" href="#">{{ brand.name }} </a><span>({{ brand.products }})</span>
                                </li>
                            </ul>
                        </div>

                        <div class="sidebar-widget tag">
                            <h2 class="title">Tags Cloud</h2>
                            <template v-for="tag in tagStore.tags">
                                <a @click.prevent="changeTag(tag.id)" :class="tag.id == productStore.filter.tag ? 'disabled' : ''" href="#">{{ tag.name }}</a>
                            </template>
                        </div>
                    </div>
                    <!-- Side Bar End -->
                </div>
            </div>
        </div>
        <!-- Product List End -->

        <!-- Brand Start -->
        <div class="brand">
            <div class="container-fluid">
                <div class="brand-slider">
                    <div class="brand-item"><img src="img/brand-1.png" alt=""></div>
                    <div class="brand-item"><img src="img/brand-2.png" alt=""></div>
                    <div class="brand-item"><img src="img/brand-3.png" alt=""></div>
                    <div class="brand-item"><img src="img/brand-4.png" alt=""></div>
                    <div class="brand-item"><img src="img/brand-5.png" alt=""></div>
                    <div class="brand-item"><img src="img/brand-6.png" alt=""></div>
                </div>
            </div>
        </div>
        <!-- Brand End -->
</template>
<script setup>
import { onMounted } from "vue";
import { useProductStore } from '~/store/product';
import { useCategoryStore } from '~/store/category';
import { useBrandStore } from '~/store/brand';
import { useTagStore } from '~/store/tag';
const productStore = useProductStore()
const categoryStore = useCategoryStore()
const brandStore = useBrandStore()
const tagStore = useTagStore()

const pricesRange = [
        {from: 0, to: 50},
        {from: 51, to: 100},
        {from: 101, to: 150},
        {from: 151, to: 200},
        {from: 201, to: 250},
        {from: 251, to: 300},
        {from: 301, to: 350},
        {from: 351, to: 400},
        {from: 401, to: 450},
        {from: 451, to: 500}
    ]

const currentPage = ref(1)
onMounted(() => {
    productStore.setProducts()
    categoryStore.setCategories()
    brandStore.setBrands()
    tagStore.setTags()
})

const onClickPagination = (page) => {
    productStore.setProducts()
};
const changeSort = (sort, direction) => {
    productStore.sort.sort = sort
    productStore.sort.direction = direction
    productStore.setProducts()
};
const changePriceRange = (from, to) => {
    productStore.filter.price_from = from
    productStore.filter.price_to = to
    productStore.setProducts()
};
const changeSearch = (value) => {
    productStore.filter.q = value
    productStore.setProducts()
};
const changeBrand = (value) => {
    productStore.filter.brand = value
    productStore.setProducts()
};
const changeTag = (value) => {
    productStore.filter.tag = value
    productStore.setProducts()
};
</script>

<style>
.componentContainer {
    display: flex!important;
}
.product-view .pagination .page-link {
    color: #353535;
    border-color: #353535;
}
.product-view .pagination li:hover .page-link, .product-view .pagination li .active.page-link {
    color: #FF6F61;
    background: #000000;
}
.pagination li:first-child .page-link {
    margin-left: 0;
    border-top-left-radius: 0.25rem;
    border-bottom-left-radius: 0.25rem;
}
.pagination li:last-child .page-link {
    border-top-right-radius: 0.25rem;
    border-bottom-right-radius: 0.25rem;
}
.nav-link.disabled {
    opacity: 0.6;
}
.sidebar-widget.tag a.disabled {
    opacity: 0.6;
}
.sidebar-widget.tag a.disabled:hover {
    background: white;
    color: #353535;
    border: 1px solid #353535;
    cursor: default;
}
.sidebar-widget.brands ul li a.disabled {
    color: #FF6F61;
    padding-left: 10px;
}
</style>
