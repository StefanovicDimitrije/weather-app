<template>
    <div class="text-center">
        <h2 class="text-3xl font-bold mb-2">Log in in to your account</h2>
        <p class="max-w-2xl text-xl text-gray-500 lg:mx-auto">
            To get unlock all the features of the site
        </p>
        <button @click="loginGoogle" class="mt-3"><google-icon/></button>
    </div>
</template>

<script>

import GoogleIcon from 'vue-material-design-icons/Google.vue';
import {mapActions} from "vuex";

export default {
    name: "Login",
    components: {
        GoogleIcon
    },
    methods:{
        ...mapActions({
            loginGoogleX: 'loginGoogle'
        }),
        loginGoogle(){
            this.loginGoogleX().then((resp)=>{
                console.log(resp);
            })
        }
    }
}
</script>
