<template>
  <div>
      <div class="top-bar">
          <div class="container-fluid">
              <div class="row">
                  <div class="col-sm-6">
                      <i class="fa fa-envelope"></i>
                      support@email.com
                  </div>
                  <div class="col-sm-6">
                      <i class="fa fa-phone-alt"></i>
                      +012-345-6789
                  </div>
              </div>
          </div>
      </div>
      <div class="nav">
          <div class="container-fluid">
              <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                  <a href="#" class="navbar-brand">MENU</a>
                  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                      <span class="navbar-toggler-icon"></span>
                  </button>

                  <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                      <div class="navbar-nav mr-auto">
                          <NuxtLink to="/" class="nav-item nav-link">Home</NuxtLink>
                          <NuxtLink to="/product-list" class="nav-item nav-link">Products</NuxtLink>
                          <NuxtLink to="/product-detail" class="nav-item nav-link active">Product Detail</NuxtLink>
                          <NuxtLink to="/cart" class="nav-item nav-link">Cart</NuxtLink>
                          <NuxtLink to="/checkout" class="nav-item nav-link">Checkout</NuxtLink>
                          <NuxtLink to="/my-account" class="nav-item nav-link">My Account</NuxtLink>
                          <div class="nav-item dropdown">
                              <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">More Pages</a>
                              <div class="dropdown-menu">
                                  <NuxtLink to="/wishlist" class="dropdown-item">Wishlist</NuxtLink>
                                  <NuxtLink to="/contact" class="dropdown-item">Contact Us</NuxtLink>
                              </div>
                          </div>
                      </div>
                      <div class="navbar-nav ml-auto">
                          <div class="nav-item dropdown">
                              <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">User Account</a>
                              <div class="dropdown-menu">
                                  <NuxtLink v-if="!authenticated" to="/login" class="dropdown-item">Login</NuxtLink>
                                  <NuxtLink v-if="authenticated" @click="logout" class="dropdown-item">Logout</NuxtLink>
                                  <NuxtLink to="/login" class="dropdown-item">Register</NuxtLink>
                              </div>
                          </div>
                      </div>
                  </div>
              </nav>
          </div>
      </div>
      <div class="bottom-bar">
          <div class="container-fluid">
              <div class="row align-items-center">
                  <div class="col-md-3">
                      <div class="logo">
                          <NuxtLink to="/">
                              <img src="img/logo.png" alt="Logo">
                          </NuxtLink>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="search">
                          <input type="text" placeholder="Search">
                          <button><i class="fa fa-search"></i></button>
                      </div>
                  </div>
                  <div class="col-md-3">
                      <div class="user">
                          <NuxtLink to="/wishlist" class="btn wishlist">
                              <i class="fa fa-heart"></i>
                              <span>(0)</span>
                          </NuxtLink>
                          <NuxtLink to="/cart" class="btn cart">
                              <i class="fa fa-shopping-cart"></i>
                              <span>(0)</span>
                          </NuxtLink>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</template>
<script lang="ts" setup>
import { storeToRefs } from 'pinia'; // import storeToRefs helper hook from pinia
import { useAuthStore } from '~/store/auth'; // import the auth store we just created
const router = useRouter();
const { logUserOut } = useAuthStore(); // use authenticateUser action from  auth store
const { authenticated } = storeToRefs(useAuthStore()); // make authenticated state reactive with storeToRefs

const logout = () => {
    logUserOut();
    router.push('/login');
};
</script>
