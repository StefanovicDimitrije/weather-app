<template>
    <main class="grow flex items-center justify-center px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-md mb-2 px-4 sm:px-6 lg:px-8"> <!-- border border-grey-100 -->
                <div class="max-w-md w-full">
                    <router-view></router-view>
                </div>
            </div>
    </main>
    <div class="min-h-full flex items-center justify-center my-8 px-4 sm:px-6 lg:px-8">
            <div class=" max-w-md w-full flex grow gap-x-2 items-center md:w-36 lg:w-44">
                <div class="border-t border-grey-100 w-full mt-1"></div>
                <router-link to="/landing" class="font-medium text-gray-300 hover:text-white transition ease-in-out duration-400">Home</router-link>
                <div class="border-t border-grey-100 w-4 mt-1"></div>
                <router-link to="/login" class="font-medium text-gray-300 hover:text-white transition ease-in-out duration-400">Login</router-link>
                <!--<router-link to="/register" class="font-medium text-gray-300 hover:text-white transition ease-in-out duration-400">Register</router-link>-->
                <div class="border-t border-grey-100 w-full mt-1"></div>
            </div>
    </div>
</template>

<script>
export default {
    name: "GuestLayout"
}
</script>
