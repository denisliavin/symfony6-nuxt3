<template>
        <!-- Breadcrumb Start -->
        <div class="breadcrumb-wrap">
            <div class="container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Products</a></li>
                    <li class="breadcrumb-item active">Login & Register</li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumb End -->

        <!-- Login Start -->
        <div class="login">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="register-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>First Name</label>
                                    <input class="form-control" type="text" placeholder="First Name">
                                </div>
                                <div class="col-md-6">
                                    <label>Last Name"</label>
                                    <input class="form-control" type="text" placeholder="Last Name">
                                </div>
                                <div class="col-md-6">
                                    <label>E-mail</label>
                                    <input class="form-control" type="text" placeholder="E-mail">
                                </div>
                                <div class="col-md-6">
                                    <label>Mobile No</label>
                                    <input class="form-control" type="text" placeholder="Mobile No">
                                </div>
                                <div class="col-md-6">
                                    <label>Password</label>
                                    <input class="form-control" type="text" placeholder="Password">
                                </div>
                                <div class="col-md-6">
                                    <label>Retype Password</label>
                                    <input class="form-control" type="text" placeholder="Password">
                                </div>
                                <div class="col-md-12">
                                    <button class="btn">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="login-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>E-mail / Username</label>
                                    <input
                                        v-model="user.username"
                                        class="form-control"
                                        type="text"
                                        placeholder="E-mail / Username"
                                        required
                                    >
                                </div>
                                <div class="col-md-6">
                                    <label>Password</label>
                                    <input
                                        v-model="user.password"
                                        class="form-control"
                                        type="text"
                                        placeholder="Password"
                                    >
                                </div>
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="newaccount">
                                        <label class="custom-control-label" for="newaccount">Keep me signed in</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button @click.prevent="tryLogin" class="btn">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Login End -->
</template>
<script setup>
import { storeToRefs } from 'pinia'; // import storeToRefs helper hook from pinia
import { useUserStore } from '~/store/user'; // import the auth store we just created

const { login } = useUserStore(); // use authenticateUser action from  auth store

const user = ref({
    username: 'dddddddd@www.www',
    password: 'dddddddd',
    errorText: '',
});
const router = useRouter();

const tryLogin = async () => {
    let data = await login(user.value);

    if(data.res){
        user.login = '';
        user.password = '';
        user.errorText = '';

        router.push('/my-account');
    }
    else{
        user.errorText = data.errors.join(',');
    }
};
</script>
