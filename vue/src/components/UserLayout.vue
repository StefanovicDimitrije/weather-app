<template>
    <main class="grow flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-lg px-4 sm:px-6 lg:px-8"> <!-- border border-grey-100 -->
            <div class="max-w-lg w-full">
                <router-view></router-view>
            </div>
        </div>
    </main>
    <div class="min-h-full flex items-center justify-center my-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full flex grow gap-x-2 items-center md:w-36 lg:w-44">
            <div class="border-t border-grey-100 w-full mt-1"></div>
                <router-link to="/home" class="text-gray-300 hover:text-white transition ease-in-out duration-400 min-w-fit">Current</router-link>
            <div class="border-t border-grey-100 w-6 mt-1"></div>
                <router-link to="/more" class="text-gray-300 hover:text-white transition ease-in-out duration-400 min-w-fit">12 Hour</router-link>
            <div class="border-t border-grey-100 w-6 mt-1"></div>
                <button @click="logoutUser" class="cursor-pointer text-gray-300 hover:text-white transition ease-in-out duration-400 min-w-fit">Logout</button>
            <div class="border-t border-grey-100 w-full mt-1"></div>
        </div>
    </div>
</template>

<script>

import {mapActions, mapState} from "vuex";
import router from "../router";

export default {
    name: "UserLayout",
    methods:{
        ...mapActions({
            logout: 'logout'
        }),
        logoutUser(){
            this.logout().then((response)=>{
                router.push({
                    name:'Landing'
                })
            })
        }
    }
}
</script>
